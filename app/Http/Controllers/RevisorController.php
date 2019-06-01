<?php

namespace App\Http\Controllers;

use App\Asignacion;
use App\Categoria;
use App\ControlStock;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemPedidoEntregado;
use App\ItemTemporalPedido;
use App\Pedido;
use App\TipoCategoria;
use App\TipoCompra;
use App\Unidad;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevisorController extends Controller
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
//        dd($request->all());

        for($i=0;$i<count($request->item_id_temp);$i++){
            $ipt = ItemTemporalPedido::find($request->item_id_temp[$i]);
            $ipt->tipo_compra_id = $request->tipo_compra_tmp[$i];

            $ipt->save();

        }

        for($i=0;$i<count($request->idTemp);$i++){
            $array_control_temporal = [
                'stock'=>$request->stock_tmp[$i],
                'revisor_id'=>Auth::id(),
                'items_temporales_pedidos_id'=>$request->idTemp[$i],
            ];
//dd($array_control_temporal);
            $control_stock = ControlStock::where('items_temporales_pedidos_id','LIKE',$request->idTemp[$i])->first();

            if(count($control_stock)>0){
                $control_stock->stock = $request->stock_tmp[$i];
                $control_stock->save();

            }else{
                $control = new ControlStock($array_control_temporal);
                $control->save();
            }

        }

        for($i=0;$i<count($request->item_id);$i++){
            $ip = ItemPedido::find($request->item_id[$i]);
            $ip->tipo_compra_id = $request->tipo_compra[$i];

            $ip->save();

            $item_agregar_tipo_compra = Item::find($ip->item_id);
            $item_agregar_tipo_compra->tipo_compra_id = $request->tipo_compra[$i];

            $item_agregar_tipo_compra->save();

        }

        for($i=0;$i<count($request->idReg);$i++){
//            $item_pedidos = ItemPedido::find($request->idReg[$i]);
            $array_control_registrados = [
                'stock'=>$request->stock[$i],
                'revisor_id'=>Auth::id(),
                'items_pedidos_id'=>$request->idReg[$i],
            ];

            $control_stock = ControlStock::where('items_pedidos_id','LIKE',$request->idReg[$i])->first();

            if(count($control_stock)>0){
                $control_stock->stock = $request->stock[$i];
                $control_stock->save();

            }else{
                $control = new ControlStock($array_control_registrados);
                $control->save();
            }

//
//            $item = Item::find($item_pedidos->item_id);
//            $item->tipo_compra_id = '2';
        }

        $motivo = null;
        if($request->motivo != ""){
            $motivo = strtoupper($request->motivo);
        }else{
            $motivo = "REVISADO POR EL ENCARGADO DE ACTIVOS FIJOS";
        }

        $array_estado_pedido = [
            'motivo'=>$motivo,
            'user_id'=>Auth::id(),
            'estado_id'=>10,
            'pedido_id'=>$request->pedido_id
        ];
        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido con el código ".$estado_pedido->pedido->codigo." revisado correctamente...");
        return redirect()->action('PedidosController@index');
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
        $tipo_compras = TipoCompra::all();
        $unidades = Unidad::all();
        $items = Item::all();
        $usuarios = User::all()
            ->where('rol_id','=',4);

        $a_month_ago = Carbon::now()->subMonth();

        return view('revisor.edit')
            ->withTipos($tipos)
            ->withCategorias($categorias)
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
