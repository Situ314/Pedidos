<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Empresa;
use App\EstadoPedido;
use App\Item;
use App\ItemPedidoEntregado;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use App\SalidaAlmacen;
use App\SalidaItem;
use App\TipoCategoria;
use App\Unidad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Session;

class ResponsableController extends Controller
{
    public function __construct()
    {
        $this->middleware('resp');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->rol_id > 3){
            //OBTENIENDO PEDIDOS ASIGNADOS CUYO RESPONSABLE FUE EL ULTIMO USUARIO DEL PEDIDO
            $pedidos_asignados_array = DB::table('asignaciones as t1')
                ->select('t1.pedido_id')
                ->leftJoin('asignaciones as t2',function ($join){
                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
                        ->on('t1.id', '<', 't2.id');
                })
                ->where('t1.asignado_id','=',Auth::id())
                ->where('t1.pedido_id','=',$id)
                ->whereNull('t2.id')
                ->get();

            if(count($pedidos_asignados_array)==0){
                return redirect()->back()
                    ->withErrors(array('error'=>'No puede modificar un pedido no asignado a usted'));
            }
        }
        $pedido = Pedido::find($id);

        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();

        $users = User::where('rol_id','=',4)
            ->get();

        $empresas = Empresa::all();
        $proyectos = Proyecto::all();

        return view('responsable.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)

            ->withPedido($pedido)
            ->withResponsables($users)

            ->withEmpresas($empresas)
            ->withProyectos($proyectos);
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
        $ot = null;
        if($request->num_ot != ""){
            $ot = $request->num_ot;
        }

        $area = null;
        if($request->area != ""){
            $area = $request->area;
        }

        $array_salida_almacen = [
            'num_ot'=>$ot,
            'area'=>strtoupper($area),
            'pedido_id'=>$id,
            'responsable_entrega_id'=>$request->responsable_entrega_id
        ];
        $salida_almacen = new SalidaAlmacen($array_salida_almacen);
        $salida_almacen->save();

        //INGRESO DE ITEMS DE SALIDA
        $estado = 4;
        $estado_descripcion = "en proceso ...";
        for($i=0 ; $i<count($request->input_radio_entrega) ; $i++){
            if($request->input_radio_entrega[$i]==1){ //ENTREGARA ESTE ITEM
                $array_items_salida = [
                    'cantidad'=>$request->cantidad[$i],
                    'item_pedido_entregado_id'=>$request->item_id_edit[$i],
                    'salida_id'=>$salida_almacen->id
                ];
                $sal_item = new SalidaItem($array_items_salida);
                $sal_item->save();

                /*if($request->cantidad[$i] != $request->cantidad_guardada[$i]){
                    $estado = 5; //SI ES DISTINTO FALTAN ITEMS - EN ESPERA
                    $estado_descripcion = "en espera ...";
                }
            }else{
                $estado = 5; //SI NO HAY TODOS FALTAN ITEMS - EN ESPERA
                $estado_descripcion = "en espera ...";*/
            }
        }

        $array_estado_pedido = [
            'user_id'=>Auth::id(),
            'estado_id'=>$estado,
            'pedido_id'=>$id
        ];
        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido ".Pedido::find($id)->codigo. " cambio a ".$estado_descripcion);
        return redirect()->action('PedidosController@index');

        /*$arrayItemsEntregado = [];

        for($i=0; $i<count($request->item_id_edit) ; $i++){
            //GUARDANDO ITEM TEMPORAL PARA VERIFICAR LA ELIMINACION
            array_push($arrayItemsEntregado, $request->item_id_edit[$i]);

            //OBTENIENDO ITEMS PARA VER CAMBIOS
            $item_pedido_entregado = ItemPedidoEntregado::find($request->item_id_edit[$i]);

            if($request->cantidad[$i] != $item_pedido_entregado->cantidad){
                $item_pedido_entregado->cantidad = $request->cantidad[$i];
            }

            $item_pedido_entregado->save();
        }

        if(count($arrayItemsEntregado)>0){
            ItemPedidoEntregado::whereNotIn('id',$arrayItemsEntregado)
                ->where('pedido_id','=',$id)
                ->delete();
        }

        $array_estado_pedido = [
            'user_id'=>Auth::id(),
            'estado_id'=>4,
            'pedido_id'=>$id
        ];

        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido con codigo ".Pedido::find($id)->codigo." en proceso...");
        return redirect()->action('PedidosController@index');*/
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

    /**
     * METODO QUE PERMITE EL CAMBIO DE PEDIDO A PROCESO
     */
    public function postProceso(Request $request){
        $motivo = null;
        if($request->motivo!=""){
            $motivo = strtoupper($request->motivo);
        }
        $array_estado_pedido = [
            'motivo'=>$motivo,
            'user_id' => Auth::id(),
            'estado_id'=>4,
            'pedido_id'=>$request->pedido_proceso_id
        ];
        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido con codigo ".Pedido::find($request->pedido_proceso_id)->codigo." en proceso...");
        return redirect()->action('PedidosController@index');

    }
}
