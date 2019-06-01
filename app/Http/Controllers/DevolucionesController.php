<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemTemporalPedido;
use App\Pedido;
use App\Proyecto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

class DevolucionesController extends Controller
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
        $estado = null;
        $anuncion = null;
        switch ($request->tipo_dev){
            case 1: //RECHAZADO
                $anuncion = "rechazado ...";
                $estado = 7;

                break;
            case 2: //OBSERVADO
                $anuncion = "observado ...";
                $estado = 6;
                break;
            case 3: //EN ESPERA
                $anuncion = "espera ...";
                $estado = 9;
                break;
            case 4: //OBSERVADO POR CONTROL ACTIVO FIJO
                $anuncion = "observado por activo fijo ...";
                $estado = 11;
                break;
        }

        $array_devolucion = [
            'motivo' => strtoupper($request->motivo),
            'user_id' => Auth::id(),
            'estado_id' =>$estado,
            'pedido_id' =>$request->pedido_id
        ];
        $estados_pedido = new EstadoPedido($array_devolucion);
        $estados_pedido->save();

        Session::flash('success', "Pedido con codigo ".Pedido::find($request->pedido_id)->codigo." ".$anuncion);
        return redirect()->action('PedidosController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTic(Request $request)
    {
        $pedido_antiguo = Pedido::find($request->pedido_id);

        $array_pedido = [
            'codigo'=>$this->codigo_correlativo($pedido_antiguo->proyecto_id, '20'),
            'num_solicitud'=>null,
            'area_id'=>null,
            'proyecto_id'=>$pedido_antiguo->proyecto_id,
            'oficina_id'=>$pedido_antiguo->oficina_id,
            'tipo_categoria_id'=>'20',
            'solicitante_id'=>$pedido_antiguo->solicitante_id
        ];
        $pedido = new Pedido($array_pedido);
        $pedido->save();

        $items_temp = $pedido_antiguo->items_temp_pedido;
        if(count($items_temp)>0) {
            //dd($items_temp);
            for ($i = 0; $i < count($items_temp); $i++) {

                $array_item__temp_pedido = [
                    'cantidad' => $items_temp[$i]->cantidad,
                    'pedido_id' => $pedido->id,
                    'item_temp_id' => $items_temp[$i]->item->id,
                    'tipo_compra_id' => $items_temp[$i]->tipo_compra_id
                ];

                $item_temp_pedido = new ItemTemporalPedido($array_item__temp_pedido);
                $item_temp_pedido->save();
            }
        }
//
        $items_reg = $pedido_antiguo->items_pedido;
        if(count($items_reg)>0){
//            dd($items_reg);
            for($i=0;$i<count($items_reg);$i++){

                $array_item_pedido = [
                    'cantidad'=>$items_reg[$i]->cantidad,
                    'precio_unitario'=>$items_reg[$i]->precio_unitario,
                    'pedido_id'=>$pedido->id,
                    'item_id'=>$items_reg[$i]->item->id,
                    'tipo_compra_id'=>$items_reg[$i]->tipo_compra_id
                ];
                $item_pedido = new ItemPedido($array_item_pedido);
                $item_pedido->save();

                $item_cambio = Item::find($items_reg[$i]->item->id);
                $item_cambio->tipo_categoria_id = '20';
                $item_cambio->save();
            }

        }

        $estados = $pedido_antiguo->estados_pedido;
        for($i=0;$i<count($estados);$i++){
            $array_estados = [
                'motivo' => $estados[$i]->motivo,
                'user_id' => $estados[$i]->user_id,
                'estado_id' =>$estados[$i]->estado_id,
                'pedido_id' =>$pedido->id
            ];
            $estados_pedido = new EstadoPedido($array_estados);
            $estados_pedido->save();
        }

        $array_devolucion_ant = [
            'motivo' => 'Pedido derivado al Departamento de TICs, este pedido esta en estado RECHAZADO, pero se genero un nuevo pedido con el código '. $pedido->codigo.' y seguira su rumbo correspondiente.',
            'user_id' => Auth::id(),
            'estado_id' =>'7',
            'pedido_id' =>$request->pedido_id
        ];
        $estados_pedido_ant = new EstadoPedido($array_devolucion_ant);
        $estados_pedido_ant->save();


        Session::flash('success', "Pedido con codigo ".Pedido::find($request->pedido_id)->codigo." ha sido derivado al Departamento de TIC's. Se generó un nuevo pedido con el código ".$pedido->codigo.".");
        return redirect()->action('PedidosController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTepco (Request $request)
    {
        $pedido_antiguo = Pedido::find($request->pedido_id);

        $array_pedido = [
            'codigo'=>$this->codigo_correlativo($pedido_antiguo->proyecto_id, $request->tipo_cat_id),
            'num_solicitud'=>null,
            'area_id'=>null,
            'proyecto_id'=>$pedido_antiguo->proyecto_id,
            'oficina_id'=>$pedido_antiguo->oficina_id,
            'tipo_categoria_id'=>$request->tipo_cat_id,
            'solicitante_id'=>$pedido_antiguo->solicitante_id
        ];
        $pedido = new Pedido($array_pedido);
        $pedido->save();

        $items_temp = $pedido_antiguo->items_temp_pedido;
        if(count($items_temp)>0) {
            //dd($items_temp);
            for ($i = 0; $i < count($items_temp); $i++) {

                $array_item__temp_pedido = [
                    'cantidad' => $items_temp[$i]->cantidad,
                    'pedido_id' => $pedido->id,
                    'item_temp_id' => $items_temp[$i]->item->id,
                    'tipo_compra_id' => $items_temp[$i]->tipo_compra_id
                ];

                $item_temp_pedido = new ItemTemporalPedido($array_item__temp_pedido);
                $item_temp_pedido->save();
            }
        }
//
        $items_reg = $pedido_antiguo->items_pedido;
        if(count($items_reg)>0){
//            dd($items_reg);
            for($i=0;$i<count($items_reg);$i++){

                $array_item_pedido = [
                    'cantidad'=>$items_reg[$i]->cantidad,
                    'precio_unitario'=>$items_reg[$i]->precio_unitario,
                    'pedido_id'=>$pedido->id,
                    'item_id'=>$items_reg[$i]->item->id,
                    'tipo_compra_id'=>$items_reg[$i]->tipo_compra_id
                ];
                $item_pedido = new ItemPedido($array_item_pedido);
                $item_pedido->save();

                $item_cambio = Item::find($items_reg[$i]->item->id);
                $item_cambio->tipo_categoria_id = $request->tipo_cat_id;
                $item_cambio->save();
            }

        }

        $estados = $pedido_antiguo->estados_pedido;
        for($i=0;$i<count($estados);$i++){
            $array_estados = [
                'motivo' => $estados[$i]->motivo,
                'user_id' => $estados[$i]->user_id,
                'estado_id' =>$estados[$i]->estado_id,
                'pedido_id' =>$pedido->id
            ];
            $estados_pedido = new EstadoPedido($array_estados);
            $estados_pedido->save();
        }

        $array_devolucion_ant = [
            'motivo' => 'Pedido derivado a TEPCO, este pedido pasara a estado RECHAZADO, pero se genero un nuevo pedido con el codigo '. $pedido->codigo.' y seguira su rumbo correspondiente.',
            'user_id' => Auth::id(),
            'estado_id' =>'7',
            'pedido_id' =>$request->pedido_id
        ];
        $estados_pedido_ant = new EstadoPedido($array_devolucion_ant);
        $estados_pedido_ant->save();

        Session::flash('success', "Pedido con codigo ".Pedido::find($request->pedido_id)->codigo." ha sido derivado a Tepco. Se generó un nuevo pedido con el código ".$pedido->codigo.".");
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
}
