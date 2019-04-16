<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemPedidoEntregado;
use App\Pedido;
use App\TipoCategoria;
use App\Unidad;
use App\User;
use App\TipoCompra;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Session;
class AsignacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('asig');
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
     * Metodo que guardara el pedido en la tabla de items_entregado que es la ultima tabla de pedidos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        try{
            $pedido = Pedido::find($request->pedido_id);

            //VERIFICANDO SI ALGUN VALOR CAMBIO EN EL PEDIDO
            /*if($pedido->proyecto_id != $request->proyecto_id){
                $pedido->proyecto_id = $request->proyecto_id;
            }*/

            if($pedido->tipo_categoria_id != $request->tipo_cat_id){
                $pedido->tipo_categoria_id = $request->tipo_cat_id;
            }
            $pedido->save();

            $aux_item_pedido = 0;

//            dd($request->all());
            for($i=0 ; $i<count($request->txtItem) ; $i++){
                if($request->item_id_edit[$i]!=0){ //ES ANTIGUO - VERIFICAR
                    if($request->txtItem[$i]!=""){ //ES UN ITEM ESCRITO
                        //********************REGISTRADO DE ITEMS
                        //REGISTRANDO ITEM
                        $array_item = [
                            'nombre'=>strtoupper($request->txtItem[$i]),
                            'confirmado'=>0,
                            'tipo_categoria_id'=>$request->tipo_cat_id,
                            'unidad_id'=>$request->txtUnidad[$i]
                        ];
                        $item = new Item($array_item);
                        $item->save();

                        //ITEM REGISTRADO EN PEDIDO A ENTREGAR
                        $array_item_pedido_entregado = [
                            'cantidad'=>$request->cantidad[$i],
                            'pedido_id'=>$request->pedido_id,
                            'item_id'=>$item->id
                        ];
                        $item_pedido_entregado = new ItemPedidoEntregado($array_item_pedido_entregado);
                        $item_pedido_entregado->save();
                        //*************************************************************
                    }else{ //ES UN ITEM EN BASE DE DATOS
                        //ITEM REGISTRADO EN PEDIDO A ENTREGAR

                        $getItem = Item::find($request->item_id[$aux_item_pedido]);
//                        dd($getItem);
                        if($getItem->unidad_id != $request->txtUnidad[$i]){

                            $getItem->unidad_id = $request->txtUnidad[$i];
                            $getItem->save();
                        }

                        $array_item_pedido_entregado = [
                            'cantidad'=>$request->cantidad[$i],
                            'pedido_id'=>$request->pedido_id,
                            'item_id'=>$request->item_id[$aux_item_pedido]
                        ];
                        $item_pedido_entregado = new ItemPedidoEntregado($array_item_pedido_entregado);
                        $item_pedido_entregado->save();

                        $aux_item_pedido++;
                    }
                }else{ //ES NUEVO - CREAR
                    if($request->txtItem[$i]!=""){ //ES UN ITEM ESCRITO
                        //CREANDO ITEM ESCRITO - REGISTRANDO EL ITEM
                        $array_item = [
                            'nombre'=>strtoupper($request->txtItem[$i]),
                            'confirmado'=>0,
                            'tipo_categoria_id'=>$request->tipo_cat_id,
                            'unidad_id'=>$request->txtUnidad[$i]
                        ];
                        $item = new Item($array_item);
                        $item->save();

                        //ITEM REGISTRADO EN PEDIDO A ENTREGAR
                        $array_item_pedido_entregado = [
                            'cantidad'=>$request->cantidad[$i],
                            'pedido_id'=>$request->pedido_id,
                            'item_id'=>$item->id
                        ];
                        $item_pedido_entregado = new ItemPedidoEntregado($array_item_pedido_entregado);
                        $item_pedido_entregado->save();
                    }else{ //ES UN ITEM EN BASE DE DATOS

                        $getItem = Item::find($request->item_id[$aux_item_pedido]);
//                        dd($getItem);
                        if($getItem->unidad_id != $request->txtUnidad[$i]){

                            $getItem->unidad_id = $request->txtUnidad[$i];
                            $getItem->save();
                        }
                        //ITEM REGISTRADO EN PEDIDO A ENTREGAR
                        $array_item_pedido_entregado = [
                            'cantidad'=>$request->cantidad[$i],
                            'pedido_id'=>$request->pedido_id,
                            'item_id'=>$request->item_id[$aux_item_pedido]
                        ];
                        $item_pedido_entregado = new ItemPedidoEntregado($array_item_pedido_entregado);
                        $item_pedido_entregado->save();

                        $aux_item_pedido++;
                    }
                }
            }

            //ASIGNANDO EL PEDIDO
            $array_asignacion = [
                'asignado_id'=>$request->responsable_id,
                'pedido_id'=>$request->pedido_id
            ];
            $asignado = new Asignacion($array_asignacion);
            $asignado->save();

            $motivo = null;
            if($request->motivo != ""){
                $motivo = strtoupper($request->motivo);
            }

            $array_estado_pedido = [
                'motivo'=>$motivo,
                'user_id'=>Auth::id(),
                'estado_id'=>3,
                'pedido_id'=>$request->pedido_id
            ];
            $estado_pedido = new EstadoPedido($array_estado_pedido);
            $estado_pedido->save();

            Session::flash('success', "Pedido con codigo ".$pedido->codigo." asignado correctamente...");
            return redirect()->action('PedidosController@index');
        }catch (Exception $exc){
            return redirect()->action('PedidosController@index')
                ->withErrors(array('error'=>'Algo salio mal '.$exc));
        }

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
        $pedido = Pedido::find($id);

        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();
        $usuarios = User::all()
            ->where('rol_id','=',4);
        $tipo_compras = TipoCompra::all();
        $a_month_ago = Carbon::now()->subMonth();
//        dd($a_month_ago);
//        foreach ($usuarios as $key =>$usuario){
//            $pedidos_asignados_array = DB::table('asignaciones as t1')
//                ->select('t1.pedido_id')
//                ->leftJoin('asignaciones as t2',function ($join){
//                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                        ->on('t1.id', '<', 't2.id');
//                })
//                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                ->where('t1.asignado_id','=',$usuario->id)
//                ->whereNull('t2.id');
//
//            //PREGUNTANDO LOS ESTADOS - DEVUELVEN VALORES REALES
//            //GET PARCIALES
//            $estados_pedidos_id_array_parciales = DB::table('estados_pedidos as t1')
//                ->select('t1.pedido_id as id')
//                ->leftJoin('estados_pedidos as t2',function ($join){
//                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                        ->on('t1.id', '<', 't2.id');
//                })
//                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
//                ->whereNull('t2.id')
//                ->where('t1.estado_id','=','4');
//
//            $pedidos_parciales = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_parciales)
//                ->whereDate('created_at','<',$a_month_ago)
//                ->orderBy('id','asc')
//                ->get();
//
//
//            //GET ASIGNADOS
//            $estados_pedidos_id_array_asignados = DB::table('estados_pedidos as t1')
//                ->select('t1.pedido_id as id')
//                ->leftJoin('estados_pedidos as t2',function ($join){
//                    $join->on('t1.pedido_id', '=', 't2.pedido_id')
//                        ->on('t1.id', '<', 't2.id');
//                })
//                ->leftJoin('pedidos','pedidos.id','=','t1.pedido_id')
//                ->whereIn('t1.pedido_id',$pedidos_asignados_array)
//                ->whereNull('t2.id')
//                ->where('t1.estado_id','=','3');
//
//            $pedidos = Pedido::whereIn('pedidos.id',$estados_pedidos_id_array_asignados)
//                ->whereDate('created_at','<',$a_month_ago)
//                ->orderBy('id','asc')
//                ->get();
////            dd($usuario->id , $pedidos);
//            if(count($pedidos)>0 || count($pedidos_parciales)>0){
//                $usuarios->forget($key);
//            }
//        }

//        dd($usuarios->all());

        return view('asignador.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)
            ->withUsers($usuarios)
            ->withPedido($pedido)
            ->withTipoCompras($tipo_compras);
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
}
