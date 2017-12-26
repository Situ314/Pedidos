<?php

namespace App\Http\Controllers;

use App\EstadoPedido;
use App\Pedido;
use App\Responsable;
use App\Unidad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;

class AutorizadorController extends Controller
{
    public function __construct()
    {
        $this->middleware('aut');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responsables = Responsable::where('responsables.autorizador_id','=',Auth::id())
            ->get();

        return view('autorizador.index')
            ->withResponsables($responsables);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->rol_id > 3){
            $usuarios_responsable_array = Responsable::select('solicitante_id')
                ->where('autorizador_id','=',Auth::id())
                ->get();

            $estados_pedidos_id_array = Pedido::select('pedidos.id')

                ->join('estados_pedidos','estados_pedidos.pedido_id','=','pedidos.id')

                ->where('pedidos.id','=',$id)
                ->whereIn('estados_pedidos.user_id',$usuarios_responsable_array)
                ->orWhere('estados_pedidos.user_id',Auth::id())
                ->get();


            if(count($estados_pedidos_id_array)==0){
                return redirect()->back()
                    ->withErrors(array('error'=>'No puede autorizar este pedido'));
            }
        }

        $unidades = Unidad::all();
        $pedido = Pedido::find($id);
        return view('autorizador.verificacion')
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
     * METODO QUE SE USA PARA CAMBIA EL ESTADO DEL PEDIDO A AUTORIZADO
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = Pedido::find($id);

        if(Auth::user()->rol_id > 3){
            $usuarios_responsable_array = Responsable::select('solicitante_id')
                ->where('autorizador_id','=',Auth::id())
                ->get();


            $pedido->whereIn('solicitante_id',$usuarios_responsable_array);

            if(count($pedido)==0){
                return redirect()->back()
                    ->withErrors(array('error'=>'No puede autorizar este pedido'));
            }
        }
        $array_estado_pedido = [
            'user_id'=>Auth::id(),
            'estado_id'=>2,
            'pedido_id'=>$id
        ];

        $estado_pedido = new EstadoPedido($array_estado_pedido);
        $estado_pedido->save();

        Session::flash('success', "Pedido ".$pedido->codigo." autorizado correctamente...");
        return redirect()->action('PedidosController@index');
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
     * METODO QUE CAMBIA DE USUARIO A AUTORIZADOR Y VICEVERSA
     */
    public function getCambiarRango($id, $opcion){
        $user = User::find($id);
        switch ($opcion){
            case 1: //SUBIR DE RANGO
                $user->rol_id = 5;
                $solicitantes = Responsable::where('autorizador_id','=',Auth::id())
                    ->get();

                foreach ($solicitantes as $solicitante){
                    $array_responsables = [
                        'autorizador_id'=>$user->id,
                        'solicitante_id'=>$solicitante->solicitante_id
                    ];
                    $responsable = Responsable::create($array_responsables);
                    $responsable->save();
                }
                break;
            case 2: //BAJAR DE RANGO
                $user->rol_id = 6;
                $solicitantes = Responsable::where('autorizador_id','=',$user->id)
                    ->get();
                foreach ($solicitantes as $solicitante){
                    $solicitante->delete();
                }
                break;
        }
        $user->save();

        Session::flash('success', "Usuario ".$user->empleado->nombres." cambiado correctamente...");
        return redirect()->back();
    }
}
