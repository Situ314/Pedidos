<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Empleado;
use App\Empresa;
use App\EstadoTic;
use App\Item;
use App\Oficina;
use App\Pedido;
use App\Proyecto;
use App\SalidaAlmacen;
use App\SalidaAlmacenTic;
use App\TipoCategoria;
use App\Unidad;
use App\TipoCompra;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Response;

//set_time_limit ( 50000 );
set_time_limit(3333);
class SalidaAlmacenController extends Controller
{
    public function __construct()
    {
        $this->middleware('resp',['except'=>['postSalidaItems', 'postSalidaItemsTic']]);
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
                    ->withErrors(array('error'=>'No puede completar un pedido no asignado a usted'));
            }
        }


        $pedido = Pedido::find($id);

        $tipos = TipoCategoria::orderBy('nombre');
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $items = Item::all();

        $users = User::where('rol_id','=',4)
            ->get();

        $resp_entrega = User::where('rol_id','=',7)
            ->get();

        $users_tic = User::where('rol_id','=',11)
            ->get();

        $tipo_compras = TipoCompra::all();

        $empresas = Empresa::all();
        $proyectos = Proyecto::all();
        $salida = SalidaAlmacen::where('pedido_id','=',$id)
            ->first();

        if(Auth::user()->rol_id == 11){
            $salida = SalidaAlmacenTic::where('pedido_id','=',$id)
                ->first();
        }

        $estados_tic = EstadoTic::all();

        $oficinas = Oficina::where('estado','=','Activo')
            ->get();
        //FILTRAR A EMPLEADOS A TRAVES DE SU CARGO - CHOFER, COURRIER, ETC
        $empleados = Empleado::all();

        return view('salidas.edit')
            ->withTipos($tipos)
            ->withCategroias($categorias)
            ->withUnidades($unidades)
            ->withItems($items)
            ->withResponsablestic($users_tic)

            ->withPedido($pedido)
            ->withResponsables($users)
            ->withResponsablessentrega($resp_entrega)
            ->withEmpleados($empleados)
            ->withTipoCompras($tipo_compras)
            ->withEmpresas($empresas)
            ->withProyectos($proyectos)

            ->withSalida($salida)
            ->withOficinas($oficinas)
            ->withEstadotic($estados_tic);
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
        dd($request->all(), $id);
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
        $salida = SalidaAlmacen::select('salida_almacen.num_solicitud')
            ->leftJoin('pragma_solicitudes.proyectos','salida_almacen.proyecto_id','=','pragma_solicitudes.proyectos.id')
            ->where('empresa_id','=',$request->empresa_id)
            ->whereRaw('YEAR(salida_almacen.created_at) = YEAR( NOW() )')
            ->orderBy('salida_almacen.id','desc')
            ->first();

        return Response::json(
            $salida
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

    public function postSalidaItemsTic(Request $request){
       // dd($request->all());
        $salidas = SalidaAlmacenTic::where('pedido_id','=',$request->id)
            ->get();
        foreach ($salidas as $salida){
            foreach ($salida->salida_items_tic as $salita_item){
                $salita_item->item_pedido_entregado->item->unidad;
            }
            $salida->documento;
            $salida->pedido;
        }

        return Response::json(
            $salidas
        );
    }

    public function pdfSalida($id){
        if(Auth::user()->rol_id == 11 || Auth::user()->rol_id == 10){
            $salida = SalidaAlmacenTic::find($id);

            $pdf = \PDF::loadView('pdf.pdf-salida-almacen-tic', array(
                'salida'=>$salida
            ));

            return $pdf->stream('Entrega Equipo Computacion'.$salida->id.'.pdf');
        }
        else{
            $salida = SalidaAlmacen::find($id);

//        dd($salida);
//        return view('pdf.pdf-salida-almacen')->with('salida',$salida);

            $pdf = \PDF::loadView('pdf.pdf-salida-almacen', array(
                'salida'=>$salida
            ));

            return $pdf->stream('Salida Almacen'.$salida->id.'.pdf');
        }

    }
}
