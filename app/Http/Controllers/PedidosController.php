<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\Documentos;
use App\Empleado;
use App\Empresa;
use App\Encargado;
use App\Estado;
use App\EstadoPedido;
use App\EstadoTic;
use App\Item;
use App\ItemPedido;
use App\ItemTemporal;
use App\ItemTemporalPedido;
use App\Mail\NotificacionResponsable;
use App\Oficina;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use App\TipoCategoria;
use App\TipoCompra;
use App\TipoDocumento;
use App\Unidad;
use App\User;
use App\ItemPedidoEntregado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use PhpParser\Comment\Doc;
use PhpParser\Node\Expr\ArrayItem;
use Session;
use Response;

use App\Jobs\InformePedidosJob;
use App\Jobs\NotificacionResponsableJob;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::all();
        $estados = Estado::all();
        $usuarios = User::all();


        return view('pedidos.index')
            ->withPedidos($pedidos)
            ->withEstados($estados)
            ->withUsuarios($usuarios);
    }

    /**
     * Display a listing of the resource of AUTORIZADOR.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_aut()
    {
        $pedidos = Pedido::all();
        $estados = Estado::all();
        $usuarios = User::all();

        return view('pedidos.index-autorizador')
            ->withPedidos($pedidos)
            ->withEstados($estados)
            ->withUsuarios($usuarios);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_2018()
    {
        $pedidos = Pedido::all();
        $estados = Estado::where('id','=','7')
                ->orWhere('id','=','8')
                ->get();
        $usuarios = User::all();

        return view('pedidos.index-gestiones')
            ->withPedidos($pedidos)
            ->withEstados($estados)
            ->withUsuarios($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = TipoCategoria::orderBy('nombre')->get();
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();
        $tipo_compras = TipoCompra::all();
        /*$tipos = TipoDocumento::where('id','>',1)
            ->get();*/
        $oficinas = Oficina::where('estado','=','Activo')
            ->get();
//        dd($areas->pluck('nombre','id'));
        return view('pedidos.create')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)
            ->withOficinas($oficinas)
            ->withTipoCompras($tipo_compras);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        return DB::transaction(function () use ($request) {
            $array_pedido = [
                'codigo'=>$this->codigo_correlativo($request->proyecto_id, $request->tipo_cat_id),
                'num_solicitud'=>null,
                'area_id'=>$request->area_id,
                'proyecto_id'=>$request->proyecto_id,
                'oficina_id'=>$request->oficina_id,
                'tipo_categoria_id'=>$request->tipo_cat_id,
                'solicitante_id'=>Auth::id()
            ];
//            dd($array_pedido);
            $pedido = new Pedido($array_pedido);
            $pedido->save();

            //AGREGANDO ITEMS
            $aux = 0;
            for($i=0;$i<count($request->txtItem);$i++){
                if($request->txtItem[$i]!=""){
                    $array_item_temp = [
                        'nombre'=>strtoupper($request->txtItem[$i]),
                        'unidad_id'=>$request->txtUnidad[$i]
                    ];
                    $item_pedido = new ItemTemporal($array_item_temp);
                    $item_pedido->save();

                    $array_item__temp_pedido = [
                        'cantidad'=>$request->cantidad[$i],
                        'pedido_id'=>$pedido->id,
                        'item_temp_id'=>$item_pedido->id,
                        'tipo_compra_id'=>$request->tipo_compra_id[$i],
                        'observaciones'=>$request->observacion[$i]
                    ];

//                    dd($array_item__temp_pedido);
                    $item_temp_pedido = new ItemTemporalPedido($array_item__temp_pedido);
                    $item_temp_pedido->save();
                }else{
                    $item = Item::find($request->item_id[$aux]);
                    $array_item_pedido = [
                        'cantidad'=>$request->cantidad[$i],
                        'precio_unitario'=>$item->precio_unitario,
                        'pedido_id'=>$pedido->id,
                        'item_id'=>$request->item_id[$aux],
                        'tipo_compra_id'=>$request->tipo_compra_id[$i],
                        'observaciones'=>$request->observacion[$i]
                    ];
                    $item_pedido = new ItemPedido($array_item_pedido);
                    $item_pedido->save();

                    $aux++;
                }
            }

            //AGREGANDO DOCUMENTOS
            for($i=0;$i<count($request->doc);$i++){
                $array_documento = [
                    'nombre'=>$request->doc[$i]->getClientOriginalName(),
                    'ubicacion'=>$request->doc[$i],
                    'salida_id'=>null,
                    'pedido_id'=>$pedido->id,
                    'tipo_documento_id'=>2
                ];
                $doc = new Documentos($array_documento);
                $doc->save();
            }
           // dd();

            //AGREGANDO ESTADO
            $estado = null;
            if(Auth::user()->rol_id < 5 || Auth::user()->rol_id == 7 || Auth::user()->rol_id >= 10){ //SI MENOR A AUTORIZADOR O RESPONSABLE DE ENTR.
                $estado = 2;
            }else{
                $estado = 1;
            }
            $array_estado_pedido = [
                'motivo'=>strtoupper($request->motivo),
                'user_id'=>Auth::id(),
                'estado_id'=>$estado,
                'pedido_id'=>$pedido->id
            ];
            $estado_pedido = new EstadoPedido($array_estado_pedido);
            $estado_pedido->save();

            Session::flash('success', "Pedido con codigo ".$pedido->codigo." realizado correctamente...");
            return redirect()->action('PedidosController@index');
        }, 1);

    }

    function codigo_aleatorio(){
        $letras = self::quickRandom(3);
        $numeros = mt_rand(0,999);

        $codigo = $letras.'-'.$numeros;
        $bandera = true;
        do{
            if( count(Pedido::where('codigo','=',$codigo)->first())==0 ){
                $bandera = false;

            }else{
                $letras = str_random(3);
                $numeros = mt_rand(0,999);
                $codigo = $letras.'-'.$numeros;
            }
        }while($bandera);

        return $letras.'-'.$numeros;
    }

    function codigo_correlativo($proyecto, $tipo_categoria){

            $proyecto = Proyecto::find($proyecto);

            $empresa = Empresa::find($proyecto->empresa_id);

            $letras = substr($empresa->nombre,0,3);

            if($empresa->id == 4)
                $letras = 'LPL';

            if($empresa->id == 1)
                $letras = 'PRAG';

            $gestion = Carbon::now()->year;

            $gestion = substr($gestion,2,2);

            $proyectos = Proyecto::where('empresa_id','LIKE',$empresa->id)->pluck('id');
//            dd($proyectos);
        if($tipo_categoria != '20'){
            $ultimo_pedido = Pedido::whereIn('proyecto_id',$proyectos)
                ->where('tipo_categoria_id','NOT LIKE','20')
                ->orderBy('id','DESC')
                ->first();

//        dd($ultimo_pedido);
            if($ultimo_pedido != null){
                $partes_pedido = explode('-',$ultimo_pedido->codigo);

                if(count($partes_pedido)>2 && $gestion == $partes_pedido[1]){
                    $nuevo =  str_pad($partes_pedido[2]+1, 4, '0', STR_PAD_LEFT);
                    //            dd($nuevo);
                }else{
                    $nuevo = str_pad('1', 4, '0', STR_PAD_LEFT);
                    //            dd($nuevo);
                }
            }
            else
                $nuevo = str_pad('1', 4, '0', STR_PAD_LEFT);
//        dd($partes_pedido);

            $enviar = $letras.'-'.$gestion.'-'.$nuevo;
        }else{
            $ultimo_pedido = Pedido::whereIn('proyecto_id',$proyectos)
                ->where('tipo_categoria_id','LIKE','20')
                ->orderBy('id','DESC')
                ->first();
        //dd($ultimo_pedido);
            if($ultimo_pedido != null){
                $partes_pedido = explode('-',$ultimo_pedido->codigo);

                if(count($partes_pedido)>2 && $gestion == $partes_pedido[2]){
                    $nuevo =  str_pad($partes_pedido[3]+1, 4, '0', STR_PAD_LEFT);
                    //            dd($nuevo);
                }else{
                    $nuevo = str_pad('1', 4, '0', STR_PAD_LEFT);
                    //            dd($nuevo);
                }
            }
            else
                $nuevo = str_pad('1', 4, '0', STR_PAD_LEFT);
//        dd($partes_pedido);
            $enviar = $letras.'-TIC-'.$gestion.'-'.$nuevo;
        }

//        dd($enviar);
        return $enviar;
    }

    public static function quickRandom($length)
    {
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);

        return $pedido;
    }

    /**
     * METODO QUE PERMITE LA EDICION DE UN PEDIDO
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::find($id);

        if(Auth::user()->rol_id > 3){
            if($pedido->solicitante_id != Auth::id()){
                return redirect()->back()
                    ->withErrors(array('error'=>'No puede editar un pedido que no solicito'));
            }
        }

        $documentos =  Documentos::where('pedido_id','=',$id)->get();
        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();
        $tipo_compras = TipoCompra::all();
//        dd($documentos);
        $estados_tic = EstadoTic::all();

        return view('pedidos.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)
            ->withDocumentos($documentos)
            ->withTipoCompras($tipo_compras)
            ->withPedido($pedido)
            ->withEstadotic($estados_tic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $pedido = Pedido::find($id);

        //VERIFICANDO SI ALGUN VALOR CAMBIO EN EL PEDIDO
        if($pedido->proyecto_id != $request->proyecto_id){
            $pedido->proyecto_id = $request->proyecto_id;
        }

        if($pedido->tipo_categoria_id != $request->tipo_cat_id){
            $pedido->tipo_categoria_id = $request->tipo_cat_id;
        }
        $pedido->save();

        $aux_item_pedido = 0;

        $arrayItemsTemporales = [];
        $arrayItems = [];

        for($i=0 ; $i<count($request->txtItem) ; $i++){
            if($request->item_id_edit[$i]!=0){ //ES ANTIGUO - VERIFICAR
                if($request->txtItem[$i]!=""){ //ES UN ITEM ESCRITO
                    //GUARDANDO ITEM TEMPORAL PARA VERIFICAR LA ELIMINACION
                    array_push($arrayItemsTemporales,$request->item_id_edit[$i]);

                    $item_temp_pedido = ItemTemporalPedido::find($request->item_id_edit[$i]);

                    //VERIFICANDO CAMBIOS EN EL LISTADO DE ITEMS TEMPORALES-PEDIDO
                    if($request->cantidad[$i] != $item_temp_pedido->cantidad){
                        $item_temp_pedido->cantidad = $request->cantidad[$i];
                    }

                    if($request->tipoCompra[$i] != $item_temp_pedido->tipo_compra_id){
                        $item_temp_pedido->tipo_compra_id = $request->tipo_compra_id[$i];
                    }

                    $item_temp_pedido->save();
                    //***********************************************************

                    //VERIFICANDO CAMBIOS EN ITEMS TEMPORALES
                    $item_temp = ItemTemporal::find($item_temp_pedido->item_temp_id);
                    if(strtoupper($request->txtItem[$i]) != $item_temp->nombre){
                        $item_temp->nombre = strtoupper($request->txtItem[$i]);
                    }

                    if($request->txtUnidad != $item_temp->unidad_id){
                        $item_temp->unidad_id = $request->txtUnidad[$i];
                    }


                    $item_temp->save();
                    //***********************************************************

                }else{ //ES UN ITEM EN BASE DE DATOS
                    //GUARDANDO ITEM VERIFICAR LA ELIMINACION
                    array_push($arrayItems, $request->item_id_edit[$i]);

                    $item_pedido = ItemPedido::find($request->item_id_edit[$i]);
                    //VERIFICANDO CAMBIOS EN EL LISTADO DE ITEMS-PEDIDO
                    if($request->item_id[$aux_item_pedido] != $item_pedido->item_id){
                        $item_pedido->item_id = $request->item_id[$aux_item_pedido];
                    }

                    if($request->cantidad[$i] != $item_pedido->cantidad){
                        $item_pedido->cantidad = $request->cantidad[$i];
                    }

                    if($request->tipoCompra[$i] != $item_pedido->tipo_compra_id){
                        $item_pedido->tipo_compra_id = $request->tipo_compra_id[$i];
                    }

                    $item_pedido->save();
                    $aux_item_pedido++;
                }
            }else{ //ES NUEVO - CREAR
                if($request->txtItem[$i]!=""){ //ES UN ITEM ESCRITO
                    //CREANDO ITEM TEMPORAL
                    $array_item_temp = [
                        'nombre'=>strtoupper($request->txtItem[$i]),
                        'unidad_id'=>$request->txtUnidad[$i]
                    ];

                    $item_temp = new ItemTemporal($array_item_temp);
                    $item_temp->save();

                    //AGREGANDO ITEM A LA RELACION DEL PEDIDO
                    $array_item_temp_pedido = [
                        'cantidad'=>$request->cantidad[$i],
                        'pedido_id'=>$id,
                        'item_temp_id'=>$item_temp->id
                    ];

                    $item_temp_pedido = new ItemTemporalPedido($array_item_temp_pedido);
                    $item_temp_pedido->save();

                    array_push($arrayItemsTemporales, $item_temp_pedido->id);
                }else{ //ES UN ITEM EN BASE DE DATOS
//                    echo Item::find($request->item_id[$aux_item_pedido])->precio_unitario;
                    $array_item_pedido = [
                        'cantidad'=>$request->cantidad[$i],
                        'precio_unitario'=>Item::find($request->item_id[$aux_item_pedido])->precio_unitario,
                        'pedido_id'=>$id,
                        'item_id'=>$request->item_id[$aux_item_pedido]
                    ];

                    $item_pedido = new ItemPedido($array_item_pedido);
                    $item_pedido->save();

                    array_push($arrayItems, $item_pedido->id);
                    $aux_item_pedido++;
                }
            }
        }

        if(count($arrayItems) > 0){
            ItemPedido::whereNotIn('id',$arrayItems)
                ->where('pedido_id','=',$id)
                ->delete();
        }else{
            ItemPedido::where('pedido_id','=',$id)
                ->delete();
        }

        if(count($arrayItemsTemporales)>0){
            ItemTemporalPedido::whereNotIn('id',$arrayItemsTemporales)
                ->where('pedido_id','=',$id)
                ->delete();
        }else{
            ItemTemporalPedido::where('pedido_id','=',$id)
                ->delete();
        }

        //AGREGANDO DOCUMENTOS
        for($i=0;$i<count($request->doc);$i++){
            $array_documento = [
                'nombre'=>$request->doc[$i]->getClientOriginalName(),
                'ubicacion'=>$request->doc[$i],
                'salida_id'=>null,
                'pedido_id'=>$pedido->id,
                'tipo_documento_id'=>2
            ];
            $doc = new Documentos($array_documento);
            $doc->save();
        }

        $estado = null;
        if(Auth::user()->rol_id < 5){
            $estado = 2;
        }else{
            $estado = 1;
        }

        $array_estado_pedido = [
            'motivo'=>strtoupper($request->motivo),
            'user_id'=>Auth::id(),
            'estado_id'=>$estado,
            'pedido_id'=>$id
        ];

        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido con codigo ".$pedido->codigo." actualizado correctamente...");
        return redirect()->action('PedidosController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getPedido(Request $request){
        $pedido = Pedido::where('codigo','=',$request->codigo)->first();
        $estados = Estado::all();
        $estados_pedido = null;
        $items_pedido = null;
        $items_temp_pedido = null;
        if(count($pedido)!=0){
            $estados_pedido = EstadoPedido::where('pedido_id','=',$pedido->id)->get();
        }

        return view('pedidos.parts.buscar')
            ->withPedido($pedido)
            ->withCodigo($request->codigo)
            ->withEstados($estados)
            ->withEstadosp($estados_pedido);
    }

    public function postItemsPedido(Request $request){
        $pedido = Pedido::find($request->id);

        foreach ($pedido->items_pedido as $item){
            $item->control_stock;
            $item->tipo_compra;
            $item->item->unidad;
        }

        foreach ($pedido->items_temp_pedido as $item){
            $item->control_stock;
            $item->tipo_compra;
            $item->item->unidad;
        }

        foreach ($pedido->items_entrega as $item){
            $item->item->unidad;
        }

        foreach ($pedido->salidas_almacen as $salidas){
            foreach ($salidas->salida_items as $salita_item){
                $salita_item->item_pedido_entregado->item->unidad;
            }
        }


        return Response::json(
            $pedido
        );
    }

    //METODO QUE DEVUELVE LOS PEDIDOS DEPENDIENDO DEL ESTADO
    public function postPedidos(Request $request){
        switch (Auth::user()->rol_id){
            case 1: //ROOT
            case 2: //ADMIN
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 3: //ASIGNADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                switch (intval($request->estado_id)){
                    case 1: //AUTORIZADO
                        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                        $usuarios_responsable_array = Responsable::select('solicitante_id')
                            ->where('autorizador_id','=',Auth::id())
                            ->get();

                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    case 2:
                        $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                            ->where('tipo_compra_id','=','1')
                            ->orWhere('tipo_compra_id','=','2')
                            ->get();

                        $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                            ->where('tipo_compra_id','=','1')
                            ->get();

                        $pedidos_tipo_tics = Pedido::select('id')
                            ->where('tipo_categoria_id','=','20')
                            ->get();

                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereNotIn('pedidos.id',$pedidos_con_items_AF)
                            ->whereNotIn('pedidos.id',$pedidos_con_items_temporales_AF)
                            ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
                        $pedidos_tipo_tics = Pedido::select('id')
                            ->where('tipo_categoria_id','=','20')
                            ->get();

                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                }

                break;
            case 4: //RESPONSABLE
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = Asignacion::where('asignado_id','like',Auth::id())
                    ->pluck('pedido_id')
                    ->toArray();

                $pedidos_asignados_arrayP = Pedido::where('solicitante_id','LIKE',Auth::id())
                    ->pluck('id')
                    ->toArray();
//                $pedidos_asignados_array = DB::table('asignaciones as t1')
//                    ->select('t1.pedido_id')
////                    ->leftJoin('asignaciones as t2',function ($join){
////                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
////                            ->on('t1.id', '<', 't2.id');
////                    })
////                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                    ->where('t1.asignado_id','=',Auth::id())
//                    ->pluck();
////                    ->orWhere('pedidos.solicitante_id','=',Auth::id())
////                    ->whereNull('t2.id');
//
//                $pedidos_asignados_arrayP = DB::table('pedidos as t1')
//                    ->select('t1.id')
////                    ->leftJoin('asignaciones as t2',function ($join){
////                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
////                            ->on('t1.id', '<', 't2.id');
////                    })
////                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
////                    ->where('t1.asignado_id','=',Auth::id())
//                    ->Where('t1.solicitante_id','=',Auth::id())
//                    ->pluck();
//                    ->whereNull('t2.id');

                $mezcla = array_merge($pedidos_asignados_array,$pedidos_asignados_arrayP);

//                dd($mezcla);
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                switch (intval($request->estado_id)){
                    case 2: //AUTORIZADO
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->where('pedidos.solicitante_id',Auth::id())
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('t1.pedido_id',$mezcla)
//                            ->orWhere('pedidos.solicitante_id','=',Auth::id())
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                }
                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();
//
//                $encargado_array = Encargado::select('tipo_categoria_id')
//                    ->where('user_id','=',Auth::id())
//                    ->get();
//
//                $encargado_all_array = Encargado::select('tipo_categoria_id')
//                    ->where('exclusivo','=','1')
//                    ->get();
//                dd($encargado_array->isEmpty());
//            if($encargado_array->isEmpty()){
//                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
//                    ->select('t1.pedido_id as id')
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
////                    ->whereNotIn('pedidos.tipo_categoria_id',$encargado_all_array)
//                    ->whereNull('t2.id')
//                    ->where('t1.estado_id','=',$request->estado_id);
//            }else{
//                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
//                    ->select('t1.pedido_id as id')
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->where(function ($query) use($usuarios_responsable_array,$encargado_array){
//                        $query->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
//                            ->OrwhereIn('pedidos.tipo_categoria_id',$encargado_array);
//                    })
//                    ->whereNull('t2.id')
//                    ->where('t1.estado_id','=',$request->estado_id);
//            }

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 6: //USUARIO
            case 7:
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 8: //REVISOR AF

                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();
                switch (intval($request->estado_id)){
                    case 1: //INICIAL
                        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);

                        break;
                    case 11:
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
//                        dd($pedidos_con_items_AF);
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                                $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                                    ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                            })
                            ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
//                            ->whereIn('pedidos.id',$pedidos_con_items_AF)
//                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);

//                        dd($estados_pedidos_id_array->toSql());
                        break;
                }
                break;
            case 9: //WATCHER
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','=','20')
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=','8');
                break;
            case 10: //REVISOR TICS

                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                switch (intval($request->estado_id)){
                    default: //LOS DEMAS ESTADOS
//                        dd($pedidos_con_items_AF);
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->where(function ($query) use ($pedidos_tipo_tics){
                                $query->whereIn('pedidos.id',$pedidos_tipo_tics);
                            })
//                            ->whereIn('pedidos.id',$pedidos_con_items_AF)
//                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
//                        dd($estados_pedidos_id_array->toSql());
                        break;
                }
                break;
            case 11: //RESPONSABLE TICS
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = DB::table('asignaciones as t1')
                    ->select('t1.pedido_id')
                    ->leftJoin('asignaciones as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('t1.asignado_id','=',Auth::id())
                    ->orWhere('pedidos.solicitante_id','=',Auth::id())
                    ->whereNull('t2.id');

                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                switch (intval($request->estado_id)){
                    case 2: //AUTORIZADO
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->where('pedidos.solicitante_id',Auth::id())
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                }

                break;
        }

//        if($request->estado_id == '7' || $request->estado_id == '8'){
//            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
//                ->orderBy('id','desc')
//                ->with(['asignados_nombres','estados_pedido','proyecto_empresa',
//                    'documentos','solicitante_empleado','salidas_almacen'])
//                ->whereYear('created_at','>','2018')
//                ->get();
//        }else{
            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
                ->orderBy('id','desc')
                ->with(['asignados_nombres','estados_pedido','proyecto_empresa',
                    'documentos','solicitante_empleado','salidas_almacen','salidas_almacen_tic'])
//            ->whereYear('created_at','>','2018')
                ->get();
//        }


        return Response::json(
            $pedidos
        );
    }

    //METODO QUE DEVUELVE LOS PEDIDOS DEPENDIENDO DEL ESTADO
    public function postPedidosAutorizador(Request $request){

        $usuarios_responsable_array = Responsable::select('solicitante_id')
            ->where('autorizador_id','=',Auth::id())
            ->get();

        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=',$request->estado_id);

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
            ->orderBy('id','desc')
            ->with(['asignados_nombres','estados_pedido','proyecto_empresa',
                'documentos','solicitante_empleado','salidas_almacen','salidas_almacen_tic'])
            ->get();


        return Response::json(
            $pedidos
        );
    }

    //METODO QUE DEVUELVE LOS PEDIDOS DEPENDIENDO DEL ESTADO
    //POR GESTION
    //POR AHORA 2018
    public function postPedidosGestion(Request $request){
        switch (Auth::user()->rol_id){
            case 1: //ROOT
            case 2: //ADMIN
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 3: //ASIGNADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                switch (intval($request->estado_id)){
                    case 1: //AUTORIZADO
                        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                        $usuarios_responsable_array = Responsable::select('solicitante_id')
                            ->where('autorizador_id','=',Auth::id())
                            ->get();

                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })

                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                }

                break;
            case 4: //RESPONSABLE
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = DB::table('asignaciones as t1')
                    ->select('t1.pedido_id')
                    ->leftJoin('asignaciones as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('t1.asignado_id','=',Auth::id())
                    ->orWhere('pedidos.solicitante_id','=',Auth::id())
                    ->whereNull('t2.id');

                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                switch (intval($request->estado_id)){
                    case 2: //AUTORIZADO
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->where('pedidos.solicitante_id',Auth::id())
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                    default: //LOS DEMAS ESTADOS
                        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                            ->select('t1.pedido_id as id')
                            ->leftJoin('estados_pedidos as t2',function ($join){
                                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                    ->on('t1.id', '<', 't2.id');
                            })
                            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                            ->whereNull('t2.id')
                            ->where('t1.estado_id','=',$request->estado_id);
                        break;
                }

                break;
            case 5: //AUTORIZADOR

                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 6: //USUARIO
            case 7:
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
        }

//        dd(count($estados_pedidos_id_array));

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
            ->orderBy('id','desc')
            ->with(['asignados_nombres','estados_pedido','proyecto_empresa',
                'documentos','solicitante_empleado','salidas_almacen','salidas_almacen_tic'])
            ->whereYear('created_at','=',$request->gestion)
            ->get();

        return Response::json(
            $pedidos
        );
    }

//    //METODO QUE ACTUALIZA LA CANTIDAD DE LOS TABS
//    public function postCantidad(){
//        $cantidad = null;
//        switch (Auth::user()->rol_id){
//            case 1: //ROOT
//            case 2: //ADMIN
//                $cantidad = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->whereNull('t2.id')
////                    ->whereYear('t1.created_at','=','2019')
//                    ->groupBy('t1.estado_id')
//                    ->get();
//
//                $cantidad_2019 = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->leftJoin('pedidos as p', function($join){
//                        $join->on('t1.pedido_id','=','p.id');
//
//                    })
//                    ->whereYear('p.created_at','=','2019')
//                    ->whereNull('t2.id')
//                    ->groupBy('t1.estado_id')
//                    ->get();
////            dd($cantidad_2019);
//                break;
//            case 3: //ASIGNADOR
//                $cantidad = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->whereNull('t2.id')
//                    ->groupBy('t1.estado_id')
//                    ->get();
//
//                $usuarios_responsable_array = Responsable::select('solicitante_id')
//                    ->where('autorizador_id','=',Auth::id())
//                    ->get();
//
//                $cantidad_inicial = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
//                    ->where('t1.estado_id','=','1')
//                    ->whereNull('t2.id')
//                    ->groupBy('t1.estado_id')
//                    ->first();
//
////                dd($cantidad_inicial);
////                foreach ($cantidad as $c){
////                    if($c->estado_id == 1){
////                        $c->cantidad = $cantidad_inicial;
////                        break;
////                    }
////                }
//
//                if(count($cantidad_inicial)>0)
//                    $cantidad[0]->cantidad = $cantidad_inicial->cantidad;
//                else
//                    $cantidad[0]->cantidad = 0;
////                dd($cantidad);
//                break;
//            case 4:
//                $array_search = [];
//
//                //CASO EN EL QUE LOS PEDIDOS SEAN SUYOS
//                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
//                    ->select('t1.pedido_id as pedido_id')
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                    ->where('pedidos.solicitante_id',Auth::id())
//                    ->whereNull('t2.id');
//
//                foreach ($estados_pedidos_id_array->get() as $pedido){
//                    if(!in_array($pedido->pedido_id,$array_search))
//                        array_push($array_search, $pedido->pedido_id);
//                }
//                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
//                $pedidos_asignados_array = DB::table('asignaciones as t1')
//                    ->select('t1.pedido_id')
//                    ->leftJoin('asignaciones as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->where('t1.asignado_id','=',Auth::id())
//                    ->whereNull('t2.id');
//
//                foreach ($pedidos_asignados_array->get() as $pedido){
//                    if(!in_array($pedido->pedido_id,$array_search))
//                        array_push($array_search, $pedido->pedido_id);
//                }
//
//                $cantidad = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->whereIn('t1.pedido_id',$array_search)
//                    ->whereNull('t2.id')
//                    ->groupBy('t1.estado_id')
//                    ->get();
//                echo $cantidad;
//                exit();
//
//                break;
//            case 5: //AUTORIZADOR
//                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
//
//                $usuarios_responsable_array = Responsable::select('solicitante_id')
//                    ->where('autorizador_id','=',Auth::id())
//                    ->get();
//
//                $encargado_array = Encargado::select('tipo_categoria_id')
//                    ->where('user_id','=',Auth::id())
//                    ->get();
//
//                $encargado_all_array = Encargado::select('tipo_categoria_id')
//                    ->where('exclusivo','=','1')
//                    ->get();
////                dd($encargado_array->isEmpty());
//                if($encargado_array->isEmpty()){
//                    $cantidad = DB::table('estados_pedidos as t1')
//                        ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                        ->leftJoin('estados_pedidos as t2',function ($join){
//                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                                ->on('t1.id', '<', 't2.id');
//                        })
//                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                        ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
//                        ->whereNotIn('pedidos.tipo_categoria_id',$encargado_all_array)
//                        ->whereNull('t2.id')
//                        ->groupBy('t1.estado_id')
//                        ->get();
//                }else{
//
//                    $cantidad = DB::table('estados_pedidos as t1')
//                        ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                        ->leftJoin('estados_pedidos as t2',function ($join){
//                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                                ->on('t1.id', '<', 't2.id');
//                        })
//                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                        ->where(function ($query) use($usuarios_responsable_array,$encargado_array){
//                            $query->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
//                                ->OrwhereIn('pedidos.tipo_categoria_id',$encargado_array);
//                        })
//                        ->whereNotIn('pedidos.tipo_categoria_id',$encargado_all_array)
//                        ->whereNull('t2.id')
//                        ->groupBy('t1.estado_id')
//                        ->get();
//                }
//
//                break;
//            case 6:
//            case 7:
//                $cantidad = DB::table('estados_pedidos as t1')
//                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
//                    ->leftJoin('estados_pedidos as t2',function ($join){
//                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                            ->on('t1.id', '<', 't2.id');
//                    })
//                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//    //                    ->where('t1.user_id',Auth::id())
//                    ->where('pedidos.solicitante_id',Auth::id())
//                    ->whereNull('t2.id')
//                    ->groupBy('t1.estado_id')
//                    ->get();
//                break;
//        }
//
////        dd($cantidad);
//        return Response::json(
//            $cantidad
//        );
//    }

    public function postCantidad(){
        $cantidad = null;
        switch (Auth::user()->rol_id){
            case 1: //ROOT
            case 2: //ADMIN
                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })

                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                break;
            case 9: //ADMIN
                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','=','20')
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                break;
            case 3: //ASIGNADOR
//
                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                    ->where('t1.estado_id','NOT LIKE','1')
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();

                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $cantidad_inicial = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->where('t1.estado_id','=','1')
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->first();

                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->orWhere('tipo_compra_id','=','2')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->orWhere('tipo_compra_id','=','2')
                    ->get();
//dd($pedidos_con_items_AF);
                $cantidad_AF = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereNotIn('pedidos.id',$pedidos_con_items_AF)
                    ->whereNotIn('pedidos.id',$pedidos_con_items_temporales_AF)
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                    ->where('t1.estado_id','=','2')
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->first();
//dd($cantidad_AF->cantidad);
//                if(count($cantidad_inicial)>0)
//                    $cantidad[0]->cantidad = $cantidad_inicial->cantidad;
//                else
//                    $cantidad[0]->cantidad = 0;

                if(count($cantidad_AF)>0 && $cantidad[0]->estado_id = '2')
                    $cantidad[0]->cantidad = $cantidad_AF->cantidad;
                else
                    $cantidad[0]->cantidad = 0;
                break;
            case 4:
            case 11:
                $array_search = [];

                //CASO EN EL QUE LOS PEDIDOS SEAN SUYOS
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as pedido_id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id');

                foreach ($estados_pedidos_id_array->get() as $pedido){
                    if(!in_array($pedido->pedido_id,$array_search))
                        array_push($array_search, $pedido->pedido_id);
                }
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = DB::table('asignaciones as t1')
                    ->select('t1.pedido_id')
                    ->leftJoin('asignaciones as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->where('t1.asignado_id','=',Auth::id())
                    ->whereNull('t2.id');

                foreach ($pedidos_asignados_array->get() as $pedido){
                    if(!in_array($pedido->pedido_id,$array_search))
                        array_push($array_search, $pedido->pedido_id);
                }

                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('t1.pedido_id',$array_search)
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                echo $cantidad;
                exit();

                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();


                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();

//                dd($cantidad);
                break;
            case 6:
            case 7:
                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    //                    ->where('t1.user_id',Auth::id())
                    ->where('pedidos.deleted_at','=',null)
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                break;
            case 8:
                $array_search = [];

                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                //CASO EN EL QUE LOS PEDIDOS SEAN SUYOS
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as pedido_id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id');
//                dd($estados_pedidos_id_array->get());
                foreach ($estados_pedidos_id_array->get() as $pedido){
                    if(!in_array($pedido->pedido_id,$array_search))
                        array_push($array_search, $pedido->pedido_id);
                }

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();


                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_id_af_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as pedido_id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                        $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                    })
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                    ->orWhere('t1.estado_id','=','11')
                    ->whereNull('t2.id');

                foreach ($pedidos_id_af_array->get() as $pedido){
                    if(!in_array($pedido->pedido_id,$array_search))
                        array_push($array_search, $pedido->pedido_id);
                }

                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('t1.pedido_id',$pedidos_id_af_array)
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();

//                dd($cantidad);
                echo $cantidad;
                exit();
                break;
            case 10: //REVISOR TICS

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('t1.pedido_id',$pedidos_tipo_tics)
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();


                break;

        }


        return Response::json(
            $cantidad
        );
    }

    public function postCantidadAut(){

        $usuarios_responsable_array = Responsable::select('solicitante_id')
            ->where('autorizador_id','=',Auth::id())
            ->get();


        $cantidad = DB::table('estados_pedidos as t1')
            ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->where('pedidos.deleted_at','=',null)
            ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
            ->whereNull('t2.id')
            ->groupBy('t1.estado_id')
            ->get();

        return Response::json(
            $cantidad
        );
    }

    public function postEstadosPedido(Request $request){
        $pedido = Pedido::find($request->id);

        $pedido->estados;
        $pedido->estados_pedido;
        $pedido->salidas_almacen;
        foreach ($pedido->estados_pedido as $estado){
            $estado->usuario->empleado;
        }

        return Response::json(
            $pedido
        );
    }

    //METODO QUE REALIZA LA BUSQUEDA DE LOS PEDIDOS
    public function buscarPedido(Request $request){
        $busqueda = trim($request->texto);

        $estados_pedidos_id_array = null;

        switch (Auth::user()->rol_id){
            case 1: //ROOT
            case 2: //ADMIN
            case 3: //ASIGNADOR
//            case 9: //WATCHER
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })

                    ->whereNull('t2.id');
                break;
            case 4: //RESPONSABLE
            case 11: //RESPONSABLE TICS
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = DB::table('asignaciones as t1')
                    ->select('t1.pedido_id')
                    ->leftJoin('asignaciones as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('t1.asignado_id','=',Auth::id())
                    ->orWhere('pedidos.solicitante_id','=',Auth::id())
                    ->whereNull('t2.id');

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                    ->whereNull('t2.id');
                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id');
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES

                break;
            case 6: //USUARIO
            case 7: //RESPONSABLE DE ENTREGA
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id');
                break;
            case 8:
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                        $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                    })
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
//                            ->whereIn('pedidos.id',$pedidos_con_items_AF)
//                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF)
                    ->whereNull('t2.id');

                break;
            case 10: //REVISOR TICS
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','20')
                    ->whereNull('t2.id');
                break;
            case 9: //WATCHER
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','20')
                    ->whereNull('t2.id');
                break;
        }

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
            ->orderBy('pedidos.id','DESC')
            ->with(['asignados_nombres','estados_pedido_detalle','proyecto_empresa',
                'documentos','solicitante_empleado'])
            ->get();
      //  dd($pedidos);
        $pedidos = $pedidos->filter(function ($value, $key) use ($busqueda){
            $nombre_completo = "";
            if($value->solicitante_empleado->empleado->nombres!=null && $value->solicitante_empleado->empleado->nombres!="")
                $nombre_completo=$nombre_completo.$value->solicitante_empleado->empleado->nombres;

            if($value->solicitante_empleado->empleado->apellido_1!=null && $value->solicitante_empleado->empleado->apellido_1!="")
                $nombre_completo=$nombre_completo." ".$value->solicitante_empleado->empleado->apellido_1;

            if($value->solicitante_empleado->empleado->apellido_2!=null && $value->solicitante_empleado->empleado->apellido_2!="")
                $nombre_completo=$nombre_completo." ".$value->solicitante_empleado->empleado->apellido_2;

            if($value->solicitante_empleado->empleado->apellido_3!=null && $value->solicitante_empleado->empleado->apellido_3!="")
                $nombre_completo=$nombre_completo." ".$value->solicitante_empleado->empleado->apellido_3;

            $asignado = "SIN ENCARGADO";
            if(count($value->asignados_nombres)>0){
                $var = count($value->asignados_nombres)-1;
                if(count($value->asignados_nombres[$var])>0){
                    if(isEmptyOrNullString($value->asignados_nombres[$var]->empleado_nombres->nombres))
                        $asignado = $value->asignados_nombres[$var]->empleado_nombres->nombres;

                    if(isEmptyOrNullString($value->asignados_nombres[$var]->empleado_nombres->apellido_1))
                        $asignado = $asignado." ".$value->asignados_nombres[$var]->empleado_nombres->apellido_1;

                    if(isEmptyOrNullString($value->asignados_nombres[$var]->empleado_nombres->apellido_2))
                        $asignado = $asignado." ".$value->asignados_nombres[$var]->empleado_nombres->apellido_2;

                    if(isEmptyOrNullString($value->asignados_nombres[$var]->empleado_nombres->apellido_3))
                        $asignado = $asignado." ".$value->asignados_nombres[$var]->empleado_nombres->apellido_3;

                }
            }

            $codigo = strtolower($value->codigo);
            $proyecto = strtolower($value->proyecto_empresa->nombre);
            $empresa = strtolower($value->proyecto_empresa->empresa->nombre);
            $busqueda = strtolower($busqueda);
            $nombre_completo = strtolower($nombre_completo);
            $asignado = strtolower($asignado);

            return strpos($codigo,$busqueda)!==false ||
                strpos($empresa, $busqueda) !== false ||
                strpos($nombre_completo, $busqueda) !== false ||
                strpos($proyecto, $busqueda) !== false ||
                strpos($asignado, $busqueda) !== false;
        })->all();

        return Response::json(
            $pedidos
        );
    }

    //METODO QUE REALIZA LA BUSQUEDA DE LOS PEDIDOS
    public function buscarPedidoItem(Request $request){
        $busqueda = trim($request->texto);

        $estados_pedidos_id_array = null;

        switch (Auth::user()->rol_id){
            case 1: //ROOT
            case 2: //ADMIN
            case 3: //ASIGNADOR
//            case 9: //WATCHER
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })

                    ->whereNull('t2.id');
                break;
            case 4:
            case 11://RESPONSABLE
                //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
                $pedidos_asignados_array = DB::table('asignaciones as t1')
                    ->select('t1.pedido_id')
                    ->leftJoin('asignaciones as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('t1.asignado_id','=',Auth::id())
                    ->orWhere('pedidos.solicitante_id','=',Auth::id())
                    ->whereNull('t2.id');

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                    ->whereNull('t2.id');
                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('pedidos.solicitante_id',$usuarios_responsable_array)
                    ->whereNull('t2.id');
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES

                break;
            case 6: //USUARIO
            case 7: //RESPONSABLE DE ENTREGA

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id');
                break;
            case 8:
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                        $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                    })
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
//                            ->whereIn('pedidos.id',$pedidos_con_items_AF)
//                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF)
                    ->whereNull('t2.id');

                break;
            case 10: //RESPONSABLE TICS
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','20')
                    ->whereNull('t2.id');
                break;
            case 9: //WATCHER
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where('pedidos.tipo_categoria_id','20')
                    ->whereNull('t2.id');
        }


       // dd($pedidos);

        $items = Item::all();
        $items_temp = ItemTemporal::all();

        $items = $items -> filter(function ($value, $key) use ($busqueda){
            $busqueda = strtolower($busqueda);
            $item = strtolower($value->nombre);

            return strpos($item,$busqueda)!==false;
        })->pluck('id');

        $items_temp = $items_temp -> filter(function ($value, $key) use ($busqueda){
            $busqueda = strtolower($busqueda);
            $item = strtolower($value->nombre);

            return strpos($item,$busqueda)!==false;
        })->pluck('id');
     //   dd($items);

        $pedidosEnItem = ItemPedido::whereIn('item_id',$items)
            ->pluck('pedido_id');

        $entregadoEnItem = ItemPedidoEntregado::whereIn('item_id',$items)
            ->pluck('pedido_id');

        $temporalEnItem = ItemTemporalPedido::whereIn('item_temp_id',$items_temp)
            ->pluck('pedido_id');

       // dd($pedidosEnItem);
//        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
//           // ->whereIn('pedidos.id',$pedidosEnItem)
//            ->WhereIn('pedidos.id',$entregadoEnItem)
//            ->with(['items','items_entregar','items_temporales','asignados_nombres','estados','proyecto_empresa',
//                'documentos','solicitante_empleado'])
//            ->get();

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
            ->where(function($query) use ($pedidosEnItem, $entregadoEnItem, $temporalEnItem){
                $query->whereIn('pedidos.id',$pedidosEnItem)
                    ->orWhereIn('pedidos.id',$temporalEnItem)
                    ->orWhereIn('pedidos.id',$entregadoEnItem);
            })
            ->orderBy('pedidos.id','DESC')
            ->with(['items','items_entregar','items_temporales','asignados_nombres','estados','proyecto_empresa',
                'documentos','solicitante_empleado'])
            ->get();
       // dd($pedidos);
//        $pedidos = $pedidos->whereIn('pedidos.id',$pedidosEnItem)
//            //->orWhereIn('pedidos.id',$entregadoEnItem)
//
//            ->get();

        return Response::json(
            $pedidos
        );
    }

    function IsNullOrEmptyString($str){
        return (!isset($str) || trim($str) === '');
    }

    public function getPedidoImprimirItemsSolicitados($id){
        //VERIFICAR PEDIDO
        $pedido = Pedido::find($id);
        $pedido_verificado = null;

        switch (Auth::user()->rol->id){
            case 1: //ROOT
            case 2: //ADMIN
            case 3: //ASIGNADOR
            case 10:
                $pedido_verificado = $pedido;
                break;
            case 4:
            case 11://RESPONSABLE
                $pedido_verificado = Pedido::leftJoin('asignaciones','asignaciones.pedido_id','=','pedidos.id')
                    ->where(function ($query) use ($id){
                        $query->where('pedidos.id','=',$id);
                    })->where(function ($query){
                        $query->where('asignaciones.asignado_id','=',Auth::id())
                            ->orWhere('pedidos.solicitante_id','=',Auth::id());
                    })
                    ->get();
                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $pedido_verificado = Pedido::where('id','=',$id)
                    ->whereIn('solicitante_id',$usuarios_responsable_array)
                    ->get();
                break;
            case 6: //USUARIO
            case 7: //RESP. ENTREGA
                $pedido_verificado = Pedido::where('id','=',$id)
                    ->where('solicitante_id','=',Auth::id())
                    ->get();
                break;
            case 8:
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $pedido_verificado = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                        $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                    })
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                    ->orWhere('pedidos.solicitante_id','LIKE',Auth::id())
                    ->whereNull('t2.id')
                    ->get();

                break;
        }

        if(count($pedido_verificado)>0){
            $pdf = \PDF::loadView('pdf.pdf-items-solicitados', array(
                'pedido'=>$pedido
            ));

            return $pdf->stream('Items solicitados '.$id.'.pdf');
        }else{
            return redirect()->action('PedidosController@index')
                ->withErrors(array('No tiene permiso para ver el pedido'));
        }
    }

    public function getPedidoImprimirItemsSolicitadosTic($id){
        //VERIFICAR PEDIDO
        $pedido = Pedido::find($id);
        $pedido_verificado = null;

        $pdf = \PDF::loadView('pdf.pdf-items-solicitados-tic', array(
            'pedido'=>$pedido
        ));

        return $pdf->stream('Dispositivos solicitados '.$id.'.pdf');

    }

    public function getPedidoImprimirItemsEntregados($id){

        //VERIFICAR PEDIDO
        $pedido = Pedido::find($id);
        $pedido_verificado = null;

        switch (Auth::user()->rol->id){
            case 1: //ROOT
            case 2: //ADMIN
            case 3: //ASIGNADOR
            case 10:
                $pedido_verificado = $pedido;
                break;
            case 4:
            case 11: //RESPONSABLE
                $pedido_verificado = Pedido::leftJoin('asignaciones','asignaciones.pedido_id','=','pedidos.id')
                    ->where(function ($query) use ($id){
                        $query->where('pedidos.id','=',$id);
                    })->where(function ($query){
                        $query->where('asignaciones.asignado_id','=',Auth::id())
                            ->orWhere('pedidos.solicitante_id','=',Auth::id());
                    })
                    ->get();
                break;
            case 5: //AUTORIZADOR
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $pedido_verificado = Pedido::where('id','=',$id)
                    ->whereIn('solicitante_id',$usuarios_responsable_array)
                    ->get();
                break;
            case 6: //USUARIO
            case 7: //RESP. ENTREGA
                $pedido_verificado = Pedido::where('id','=',$id)
                    ->where('solicitante_id','=',Auth::id())
                    ->get();
                break;
            case 8:
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                $pedidos_con_items_AF = ItemPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_con_items_temporales_AF = ItemTemporalPedido::select('pedido_id')
                    ->where('tipo_compra_id','=','1')
                    ->get();

                $pedidos_tipo_tics = Pedido::select('id')
                    ->where('tipo_categoria_id','=','20')
                    ->get();

                $pedido_verificado = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                    ->where(function ($query) use ($pedidos_con_items_AF,$pedidos_con_items_temporales_AF){
                        $query->whereIn('pedidos.id',$pedidos_con_items_AF)
                            ->orWhereIn('pedidos.id',$pedidos_con_items_temporales_AF);
                    })
                    ->whereNotIn('pedidos.id',$pedidos_tipo_tics)
                    ->orWhere('pedidos.solicitante_id','LIKE',Auth::id())
                    ->whereNull('t2.id')
                    ->get();

                break;
        }

        if(count($pedido_verificado)>0){
            $pdf = \PDF::loadView('pdf.pdf-items-entregar', array(
                'pedido'=>$pedido
            ));

            if(count($pedido->items_entregar)>0){
                return $pdf->stream('Items entregar '.$id.'.pdf');
            }else{
                return redirect()->action('PedidosController@index')
                    ->withErrors(array('Todavia no se asignaron items a entregar'));
            }

        }else{
            return redirect()->action('PedidosController@index')
                ->withErrors(array('No tiene permiso para ver el pedido'));
        }
    }

    /**
     * METODO QUE ENVÍA LOS DATOS AL DASHBOARD DEL RESPONSABLE
     */
    public function getDashboardResponsable(Request $request){
        $pedidos_asignados_array = DB::table('asignaciones as t1')
            ->select('t1.pedido_id')
            ->leftJoin('asignaciones as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->where('t1.asignado_id','=',Auth::id())
            ->orWhere('pedidos.solicitante_id','=',Auth::id())
            ->whereNull('t2.id');

        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
        //GET PARCIALES
        $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','4');

        $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
            ->orderBy('id','asc')
            ->get();

        //GET ASIGNADOS
        $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','3');

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
            ->orderBy('id','asc')
            ->get();

        //GET DESPACHADOS
        $estados_pedidos_id_array_despachados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','5');

        $pedidos_despachados = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_despachados)
            ->orderBy('id','asc')
            ->get();

        //GET EN ESPERA
        $estados_pedidos_id_array_espera = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','9');

        $pedidos_espera = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_espera)
            ->orderBy('id','asc')
            ->get();

        return view('responsable.dash')
            ->with('pedidos', $pedidos)
            ->with('pedidos_parciales', $pedidos_parciales)
            ->with('pedidos_despachados', $pedidos_despachados)
            ->with('pedidos_espera', $pedidos_espera);
    }

    /**
     * METODO QUE ENVÍA LOS DATOS AL DASHBOARD DEL ASIGNADOR
     */
    public function getDashboardAsignador(Request $request){
        $pedidos_asignados_array = DB::table('asignaciones as t1')
            ->select('t1.pedido_id')
            ->leftJoin('asignaciones as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereNull('t2.id');

        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
        //GET PARCIALES
        $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','4');

        $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
            ->orderBy('id','asc')
            ->get();

        //GET ASIGNADOS
        $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','3');

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
            ->orderBy('id','asc')
            ->get();

        //GET DESPACHADOS
        $estados_pedidos_id_array_despachados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','5');

        $pedidos_despachados = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_despachados)
            ->orderBy('id','asc')
            ->get();

        //GET EN ESPERA
        $estados_pedidos_id_array_espera = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','9');

        $pedidos_espera = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_espera)
            ->orderBy('id','asc')
            ->get();

        $responsables = User::where('rol_id','LIKE',4)
            ->orderBy('id','asc')
            ->get();

        return view('asignador.dash')
            ->with('pedidos', $pedidos)
            ->with('pedidos_parciales', $pedidos_parciales)
            ->with('pedidos_despachados', $pedidos_despachados)
            ->with('pedidos_espera', $pedidos_espera)
            ->with('responsables', $responsables);
    }

    /**
     * METODO QUE ENVÍA LOS DATOS AL DASHBOARD DEL ASIGNADOR
     */
    public function postPedidosXResponsable(Request $request){

        $responsable = $request->responsable_id;

        if($responsable!=0) {
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->where('t1.asignado_id','=',$responsable)
                ->whereNull('t2.id');
        }else{
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereNull('t2.id');
        }

        //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
        //GET PARCIALES
        $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','4');

        $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
            ->orderBy('id','asc')->with('proyecto_empresa')
            ->with('solicitante_empleado')
            ->with('asignados_nombres_with_trashed')
            ->with('salidas_almacen')
            ->get();

        //GET ASIGNADOS
        $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','3');

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
            ->orderBy('id','asc')
            ->with('proyecto_empresa')
            ->with('solicitante_empleado')
            ->with('asignados_nombres_with_trashed')
            ->get();

        //GET DESPACHADOS
        $estados_pedidos_id_array_despachados = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','5');

        $pedidos_despachados = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_despachados)
            ->orderBy('id','asc')
            ->with('proyecto_empresa')
            ->with('solicitante_empleado')
            ->with('asignados_nombres_with_trashed')
            ->with('salidas_almacen')
            ->get();

        //GET EN ESPERA
        $estados_pedidos_id_array_espera = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
            ->whereIn('t1.pedido_id',$pedidos_asignados_array)
            ->whereNull('t2.id')
            ->where('t1.estado_id','=','9');

        $pedidos_espera = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_espera)
            ->orderBy('id','asc')
            ->with('proyecto_empresa')
            ->with('solicitante_empleado')
            ->with('asignados_nombres_with_trashed')
            ->get();

        return Response::json(array(
            'pedidos' => $pedidos,
            'pedidos_parciales' => $pedidos_parciales,
            'pedidos_despachados' => $pedidos_despachados,
            'pedidos_espera' => $pedidos_espera
        )
        );
    }

    public function pdfInforme(Request $request){
        $partes = explode("-", $request->id);
        $responsable = $partes[0];
        $tipo = $partes[1];

        if($responsable!=0) {
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->where('t1.asignado_id','=',$responsable)
                ->whereNull('t2.id');

            $responsable_n= User::where('id','LIKE',$responsable)
                ->first();

            $responsable_nombre= $responsable_n->getEmpleadoUsuarioAttribute();
        }else{
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereNull('t2.id');

            $responsable_nombre = 'TODOS LOS RESPONSABLES';
        }

        if($tipo != '0'){
            switch ($tipo){
                case '1':
                    //GET ASIGNADOS
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','3');
                    $tipo_enviar = 'ASIGNADO';
                    break;
                case '2':
                    //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                    //GET PARCIALES
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','4');
                    $tipo_enviar = 'PARCIALES PENDIENTES';
                    break;
                case '3':
                    //GET DESPACHADOS
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','5');
                    $tipo_enviar = 'DESPACHADO';
                    break;
                case '4':
                    //GET EN ESPERA
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','9');
                    $tipo_enviar = 'EN ESPERA';
                    break;
            }

            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            $pdf = \PDF::loadView('pdf.pdf-pedidos-informe', array(
                'pedidos'=>$pedidos,
                'tipo'=>$tipo_enviar,
                'responsable'=>$responsable_nombre,
            ));
        }else{
            $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','4');

            $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
                ->orderBy('id','asc')->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->with('salidas_almacen')
                ->get();

            //GET ASIGNADOS
            $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','3');

            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            //GET DESPACHADOS
            $estados_pedidos_id_array_despachados = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','5');

            $pedidos_despachados = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_despachados)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->with('salidas_almacen')
                ->get();

            //GET EN ESPERA
            $estados_pedidos_id_array_espera = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','9');

            $pedidos_espera = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_espera)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            $pdf = \PDF::loadView('pdf.pdf-pedidos-informe-todo', array(
                'pedidos'=>$pedidos,
                'pedidos_parciales' => $pedidos_parciales,
                'pedidos_despachados' => $pedidos_despachados,
                'pedidos_espera' => $pedidos_espera,
                'responsable' => $responsable_nombre,
            ));
        }

        return $pdf->stream('Informe_Pedidos_'.$responsable.'.pdf');
    }

    public function enviarCorreo(Request $request){

        $sendToEmail = $request->email;

        $responsable = $request->responsable;
        $tipo = $request->tipo;
        $mensaje = $request->mensaje;
        $receptor = $request->nombre;

        if($responsable!=0) {
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->where('t1.asignado_id','=',$responsable)
                ->whereNull('t2.id');

            $responsable_n= User::where('id','LIKE',$responsable)
                ->first();

            $responsable_nombre= $responsable_n->getEmpleadoUsuarioAttribute();
        }else{
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereNull('t2.id');

            $responsable_nombre = 'TODOS LOS RESPONSABLES';
        }


        if($tipo != '0'){
            switch ($tipo){
                case '1':
                    //GET ASIGNADOS
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','3');
                    $tipo_enviar = 'ASIGNADO';
                    break;
                case '2':
                    //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
                    //GET PARCIALES
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','4');
                    $tipo_enviar = 'PARCIALES PENDIENTES';
                    break;
                case '3':
                    //GET DESPACHADOS
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','5');
                    $tipo_enviar = 'DESPACHADO';
                    break;
                case '4':
                    //GET EN ESPERA
                    $estados_pedidos = DB::table('estados_pedidos as t1')
                        ->select('t1.pedido_id as id')
                        ->leftJoin('estados_pedidos as t2',function ($join){
                            $join->on('t1.pedido_id', '=', 't2.pedido_id')
                                ->on('t1.id', '<', 't2.id');
                        })
                        ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                        ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                        ->whereNull('t2.id')
                        ->where('t1.estado_id','=','9');
                    $tipo_enviar = 'EN ESPERA';
                    break;
            }
            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            $pdf = \PDF::loadView('pdf.pdf-pedidos-informe', array(
                'pedidos'=>$pedidos,
                'tipo'=>$tipo_enviar,
                'responsable'=>$responsable_nombre,
            ));
//        dd($responsable_nombre);
            dispatch(new InformePedidosJob($pedidos, $responsable_nombre, $tipo_enviar,$pdf, $mensaje, $receptor, $sendToEmail));

        }else{
            $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','4');

            $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
                ->orderBy('id','asc')->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->with('salidas_almacen')
                ->get();

            //GET ASIGNADOS
            $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','3');

            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            //GET DESPACHADOS
            $estados_pedidos_id_array_despachados = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','5');

            $pedidos_despachados = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_despachados)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->with('salidas_almacen')
                ->get();

            //GET EN ESPERA
            $estados_pedidos_id_array_espera = DB::table('estados_pedidos as t1')
                ->select('t1.pedido_id as id')
                ->leftJoin('estados_pedidos as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
                ->whereNull('t2.id')
                ->where('t1.estado_id','=','9');

            $pedidos_espera = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_espera)
                ->orderBy('id','asc')
                ->with('proyecto_empresa')
                ->with('solicitante_empleado')
                ->with('asignados_nombres_with_trashed')
                ->get();

            $pdf = \PDF::loadView('pdf.pdf-pedidos-informe-todo', array(
                'pedidos'=>$pedidos,
                'pedidos_parciales' => $pedidos_parciales,
                'pedidos_despachados' => $pedidos_despachados,
                'pedidos_espera' => $pedidos_espera,
                'responsable' => $responsable_nombre,
            ));

            $tipo_enviar = 'SIN FINALIZAR';
            dispatch(new InformePedidosJob($pedidos, $responsable_nombre, $tipo_enviar,$pdf, $mensaje, $receptor, $sendToEmail));
        }
//        flash('Correo enviado exitosamente!')->success();

        return Response::json(
            $pedidos
        );
    }

    public function enviarCorreoResponsable(Request $request){

        $responsable = $request->responsable_id;
        $responsable_user = Empleado::find($responsable);
//dd($request->responsable_id);
        $pedido = Pedido::find($request->pedido_id);

        foreach ($pedido->items_pedido as $item){
            $item->item->unidad;
        }

        foreach ($pedido->items_temp_pedido as $item){
            $item->item->unidad;
        }

        foreach ($pedido->items_entrega as $item){
            $item->item->unidad;
        }

        foreach ($pedido->salidas_almacen as $salidas){
            foreach ($salidas->salida_items as $salita_item){
                $salita_item->item_pedido_entregado->item->unidad;
            }
        }

        $sendToEmail = 'carteaga@pragmainvest.com.bo';

        $email = $responsable_user->contacto_empleado->email;
        if($email == null){
            $email = $responsable_user->laboral_empleado->email_corporativo;
        }

        dd($email);
        dispatch(new NotificacionResponsableJob($pedido, $sendToEmail));

        return Response::json(
            $pedido
        );
    }
}
