<?php

namespace App\Http\Controllers;

use App\Pedido;
use App\SalidaAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Response;

class SalidaAlmacenController extends Controller
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

    public function postUltimoNumeroSalida(Request $request){
        $pedido = Pedido::select('pedidos.id','pedidos.num_solicitud')
            ->leftJoin('pragma_solicitudes.proyectos','pedidos.proyecto_id','=','pragma_solicitudes.proyectos.id')
            ->where('empresa_id','=',$request->empresa_id)
            ->whereRaw('YEAR(pedidos.created_at) = YEAR( NOW() )')
            ->orderBy('pedidos.id','desc')
            ->first();

        return Response::json(
            $pedido
        );
    }

    public function postSalidaItems(Request $request){
        $salidas = SalidaAlmacen::where('pedido_id','=',$request->id)
            ->get();

        foreach ($salidas as $salida){
            foreach ($salida->salida_items as $salita_item){
                $salita_item->item_pedido_entregado->item->unidad;
            }
            $salida->documento;
            $salida->pedido;
        }

        return Response::json(
            $salidas
        );
    }
}
