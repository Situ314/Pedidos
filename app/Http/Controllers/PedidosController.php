<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Empleado;
use App\Empresa;
use App\Estado;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemTemporal;
use App\ItemTemporalPedido;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use App\TipoCategoria;
use App\Unidad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Session;
use Response;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();

//        dd($areas->pluck('nombre','id'));
        return view('pedidos.create')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$array_empresas = explode('|',$request->empresa_id);
        $empresa_id = $array_empresas[0];
        if(Empresa::find($empresa_id)==null){
            $array_empresas = [
                'id' =>$empresa_id,
                'nombre'=>$array_empresas[1],
                'descripcion'=>$array_empresas[2]
            ];
            $empresa = new Empresa($array_empresas);
            $empresa->save();
        }

        $array_proyecto = explode('|', $request->proyecto_id);
        $proyecto_id = $array_proyecto[0];

        if(Proyecto::find($array_proyecto[0])==null){
            $array_proyecto = [
                'id'=>$array_proyecto[0],
                'nombre'=>$array_proyecto[1],
                'descripcion'=>$array_proyecto[2],
                'empresa_id'=>$empresa_id
            ];
            $proyecto = new Proyecto($array_proyecto);
            $proyecto->save();
        }

        $array_empleado = explode("|",$request->solicitante_id);
        $solicitante = $array_empleado[0];

        $empleado = Empleado::find($array_empleado[0]);
        if($empleado==null){
            $array_empleado = [
                'id'=>$array_empleado[0],
                'nombres'=>preg_replace('!\s+!', ' ', $array_empleado[1]) //ARREGLANDO MULTIPLES ESPACIOS GENERADOS
            ];
            $empleado = new Empleado($array_empleado);
            $empleado->save();
        }*/

        $array_pedido = [
            'codigo'=>$this->codigo_aleatorio(),
            'area_id'=>$request->area_id,
            'proyecto_id'=>$request->proyecto_id,
            'tipo_categoria_id'=>$request->tipo_cat_id,
            'solicitante_id'=>Auth::id()
        ];
        $pedido = new Pedido($array_pedido);
        $pedido->save();

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
                    'item_temp_id'=>$item_pedido->id
                ];
                $item_temp_pedido = new ItemTemporalPedido($array_item__temp_pedido);
                $item_temp_pedido->save();
            }else{
                $item = Item::find($request->item_id[$aux]);
                $array_item_pedido = [
                    'cantidad'=>$request->cantidad[$i],
                    'precio_unitario'=>$item->precio_unitario,
                    'pedido_id'=>$pedido->id,
                    'item_id'=>$request->item_id[$aux]
                ];
                $item_pedido = new ItemPedido($array_item_pedido);
                $item_pedido->save();

                $aux++;
            }
        }

        $array_estado_pedido = [
            'motivo'=>strtoupper($request->motivo),
            'user_id'=>Auth::id(),
            'estado_id'=>1,
            'pedido_id'=>$pedido->id
        ];
        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido con codigo ".$pedido->codigo." realizado correctamente...");
        return redirect()->action('PedidosController@index');
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
     * Show the form for editing the specified resource.
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

        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();

        return view('pedidos.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)

            ->withPedido($pedido);
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
        //
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
            $item->item->unidad;
        }

        foreach ($pedido->items_temp_pedido as $item){
            $item->item->unidad;
        }

        return Response::json(
            $pedido
        );
    }

    public function postPedidos(Request $request){
        switch (Auth::user()->rol_id){
            case 1:
            case 2:
            /*$estados_pedidos_id_array = Pedido::select('pedidos.id')

                ->join('estados_pedidos','estados_pedidos.pedido_id','=','pedidos.id')

                ->groupBy('pedidos.id')
                ->havingRaw('MAX(estados_pedidos.estado_id) = '.$request->estado_id)
                ->get();*/
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })

                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();
                /*$estados_pedidos_id_array = Pedido::select('pedidos.id')

                    ->join('estados_pedidos','estados_pedidos.pedido_id','=','pedidos.id')

                    ->whereIn('estados_pedidos.user_id',$usuarios_responsable_array)
                    ->orWhere('estados_pedidos.user_id',Auth::id())
                    ->groupBy('pedidos.id')
                    ->havingRaw('MAX(estados_pedidos.estado_id) = '.$request->estado_id)
                    ->get();*/
                $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
                    ->select('t1.pedido_id as id')
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('t1.user_id',$usuarios_responsable_array)
                    ->whereNull('t2.id')
                    ->where('t1.estado_id','=',$request->estado_id);
                break;
            case 6:
                /*$estados_pedidos_id_array = Pedido::select('pedidos.id')

                    ->join('estados_pedidos','estados_pedidos.pedido_id','=','pedidos.id')

                    ->where('estados_pedidos.user_id','=',Auth::id())
                    ->groupBy('pedidos.id')
                    ->havingRaw('MAX(estados_pedidos.estado_id) = '.$request->estado_id)
                    ->get();*/
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

        $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array)
            ->get();

        foreach ($pedidos as $pedido){
            $pedido->proyecto->empresa;
            $pedido->solicitante->empleado;
        }

        return Response::json(
            $pedidos
        );
    }

    public function postCantidad(){
        $cantidad = null;
        switch (Auth::user()->rol_id){
            case 1:
            case 2:
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
            case 3:
                break;
            case 4:
                break;
            case 5:
                $usuarios_responsable_array = Responsable::select('solicitante_id')
                    ->where('autorizador_id','=',Auth::id())
                    ->get();

                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->whereIn('t1.user_id',$usuarios_responsable_array)
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                break;
            case 6:
                $cantidad = DB::table('estados_pedidos as t1')
                    ->select('t1.estado_id',DB::raw('count(*) as cantidad'))
                    ->leftJoin('estados_pedidos as t2',function ($join){
                        $join->on('t1.pedido_id', '=', 't2.pedido_id')
                            ->on('t1.id', '<', 't2.id');
                    })
                    ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                    ->where('t1.user_id',Auth::id())
                    ->where('pedidos.solicitante_id',Auth::id())
                    ->whereNull('t2.id')
                    ->groupBy('t1.estado_id')
                    ->get();
                break;
        }


        return Response::json(
            $cantidad
        );
    }

    public function postEstadosPedido(Request $request){
        $pedido = Pedido::find($request->id);

        $pedido->estados;
        $pedido->estados_pedido;

        foreach ($pedido->estados_pedido as $estado){
            $estado->usuario->empleado;
        }

        return Response::json(
            $pedido
        );
    }

    /*public function getVerificaion($id){
        $pedido = Pedido::find($id);
        $unidades = Unidad::all();

        return view('pedidos.verificar')
            ->withPedido($pedido)
            ->withUnidades($unidades);
    }*/
}
