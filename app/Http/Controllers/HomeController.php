<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->rol_id < 5){
            $estados = Estado::all();
            return view('dash')
                ->withEstados($estados);
        }else{
            return redirect()->action('PedidosController@index');
        }
    }

    public function postPedidosGroupFecha($fecha_inicio, $fecha_final){
//        echo $fecha_inicio.' '.$fecha_final;

        $pedidos = DB::table('estados_pedidos as t1')
            ->selectRaw('t1.estado_id, count(*) as cantidad, date(t1.created_at) as fecha')
            ->leftJoin('estados_pedidos as t2',function ($join){
                $join->on('t1.pedido_id', '=', 't2.pedido_id')
                    ->on('t1.id', '<', 't2.id');
            })
            ->whereNull('t2.id')
            ->whereRaw('(date(t1.created_at) between "'.$fecha_inicio.'" and "'.$fecha_final.'")')
            ->groupBy( DB::raw('t1.estado_id, date(t1.created_at)') )
            ->get();

        return Response::json(
            $pedidos
        );
    }
}
