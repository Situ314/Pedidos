<?php

namespace App\Http\Controllers;

use App\EstadoPedido;
use App\Pedido;
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
}
