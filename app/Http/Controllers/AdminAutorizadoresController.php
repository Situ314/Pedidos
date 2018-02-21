<?php

namespace App\Http\Controllers;

use App\Responsable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;

class AdminAutorizadoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::withTrashed();
        $responsables = Responsable::all();

        $autorizadores = User::where('rol_id','=',5)
            ->get();

        if(Auth::user()->rol_id == 2){ //USUARIO ADMINISTRADOR
            $usuarios = $usuarios
                ->where('rol_id','=',6);
        }

        return view('admin.autorizadores.index')
            ->withResponsables($responsables)
            ->withAutorizadores($autorizadores)
            ->withUsers($usuarios);
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

    public function postSolicitantes(Request $request){
        $solicitantes = Responsable::where('autorizador_id','=',$request->id)
            ->get();

        foreach ($solicitantes as $solicitante){
            if(count($solicitante->solicitante->empleado)>0){
                $solicitante->solicitante->empleado->laboral_empleado->cargo;
            }else{
                $solicitante->empleado;
            }
        }

        return Response::json(
            $solicitantes
        );
    }

    public function getMisSolicitantes($id){
        $users = Responsable::where('autorizador_id','=',$id)
            ->get();

        return view('autorizador.index-equipo')
            ->withUsers($users);
    }
}
