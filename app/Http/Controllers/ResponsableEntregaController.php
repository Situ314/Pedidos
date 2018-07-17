<?php

namespace App\Http\Controllers;

use App\SalidaAlmacen;
use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Auth;

class ResponsableEntregaController extends Controller
{
    public function __construct()
    {
        $this->middleware('respent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODOS LOS PEDIDOS CON ESTADO PARCIAL O ENTREGADO
        $estados_pedidos_id_array = DB::table('estados_pedidos as t1')
            ->select('t1.pedido_id as pedido_id')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->whereNull('t2.id')
            ->where('t1.estado_id','=',4)
            ->orWhere('t1.estado_id','=',5);

        $salidas = SalidaAlmacen::where('responsable_entrega_id','=',Auth::id())
            ->whereIn('pedido_id',$estados_pedidos_id_array)
            ->orderBy('id','desc')
            ->get();

//        DB::enableQueryLog();
//        dd($estados_pedidos_id_array->get(), $salidas->get(), $salidas->toSQL(), $salidas->getBindings(), DB::getQueryLog());

        return view('responsable.impresiones.index')
            ->withSalidas($salidas);
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
}
