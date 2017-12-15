<?php

namespace App\Http\Controllers;

use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemTemporal;
use App\Pedido;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

class VerificacionController extends Controller
{
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

        for($i=0;$i<count($request->txtItemTemp);$i++){
            if($request->txtItemTemp[$i]!=""){
                $array_item = [
                    'nombre'=>strtoupper($request->txtItemTemp[$i]),
                    'descripcion'=>null,
                    'precio_unitario'=>$request->precio[$i],
                    'tipo_categoria_id'=>$request->tipo_categoria_id,
                    'unidad_id'=>$request->unidad_id[$i]
                ];
                $item = new Item($array_item);
                $item->save();

                $array_items_pedido = [
                    'cantidad'=>$request->cantidad[$i],
                    'precio_unitario'=>$request->precio[$i],
                    'pedido_id'=>$request->pedido_id,
                    'item_id'=>$item->id
                ];
                $item_pedido = new ItemPedido($array_items_pedido);
                $item_pedido->save();

                //ELIMINANDO EL ITEM TEMPORAL
                $item_temp_buscar = ItemTemporal::find($request->item_pedido_id[$i]);
                $item_temp_buscar->delete();

            }else{
                $item_pedido_buscar = ItemPedido::find($request->item_pedido_id[$i]);
                $cambiar = false;
                if($request->cantidad[$i]!=$item_pedido_buscar->cantidad){
                    $cambiar = true;
                    $item_pedido_buscar->cantidad = $request->cantidad[$i];
//                    echo "si cantidad ".$request->item_pedido_id[$i]."<br>";
                }

                if($request->precio[$i]!=$item_pedido_buscar->precio_unitario){
                    $cambiar = true;
                    $item_pedido_buscar->precio_unitario=$request->precio[$i];
//                    echo "si precio ".$request->item_pedido_id[$i]."<br>";
                }

                if($cambiar){
                    $item_pedido_buscar->save();
                }
            }
        }
        $array_estado_pedido = [
            'user_id'=>Auth::id(),
            'estado_id'=>3,
            'pedido_id'=>$request->pedido_id
        ];
        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido ".Pedido::find($request->pedido_id)->codigo."verificado correctamente...");
        return redirect()->action('PedidosController@index');
    }

    /**
     * Metodo para mostrar el pedido a ser verificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);
        $unidades = Unidad::all();

        return view('pedidos.verificar')
            ->withPedido($pedido)
            ->withUnidades($unidades);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
