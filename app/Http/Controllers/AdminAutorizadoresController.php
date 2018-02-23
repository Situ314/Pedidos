<?php

namespace App\Http\Controllers;

use App\Responsable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;
use Session;

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
        $users = User::where('rol_id','=',6)
            ->withTrashed()
            ->get();

        $autorizadores = User::where('rol_id','=',5)
            ->withTrashed()
            ->get();

        return view('admin.autorizadores.index')
            ->withAutorizadores($autorizadores)
            ->withUsers($users);
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

    public function getMisSolicitantes($id){
        $users = Responsable::where('autorizador_id','=',$id)
            ->get();
        $autorizadores = User::where('rol_id','=',5)
            ->get();
        $autorizador = User::find($id);

        return view('autorizador.index-equipo')
            ->withAutorizador($autorizador)

            ->withUsers($users)
            ->withAutorizadores($autorizadores);
    }

    public function postAutorizadores($id){
        $autorizadores = Responsable::select('autorizador_id')
            ->where('solicitante_id','=',$id)
            ->get();

        return Response::json(
            $autorizadores
        );
    }

    public function updateAutorizadores(Request $request, $id){
        //GUARDA SOLO A LOS AUTORIZADORES SELECCIONADOS
        $array_responsables_existentes = [];

        for($i=0 ; $i<count($request->autorizador_id) ; $i++){
            echo $request->autorizador_id[$i].'<br>';
            $responsable = Responsable::where('autorizador_id','=',$request->autorizador_id[$i])
                ->where('solicitante_id','=',$id)
                ->get();
            if(count($responsable)==0){
                $array_responsable = [
                    'autorizador_id'=>$request->autorizador_id[$i],
                    'solicitante_id'=>$id
                ];
                $responsable = new Responsable($array_responsable);
                $responsable->save();

                array_push($array_responsables_existentes, $request->autorizador_id[$i]);
            }else{
                array_push($array_responsables_existentes, $request->autorizador_id[$i]);
            }
        }

        Responsable::where('solicitante_id','=',$id)
            ->whereNotIn('autorizador_id',$array_responsables_existentes)
            ->delete();

        Session::flash('success', "Usuario ".User::find($id)->username." actualizado correctamente...");
        return redirect()->back();
    }

    //CAMBIA DE USUARIO A AUTORIZADOR O VICEVERSA
    public function getCambiarRol($id, $opcion){
        //PRIMERO OBTIENE EL PRIMER AUTORIZADOR DEL USUARIO
        $autorizadores = Responsable::where('solicitante_id','=',$id)
            ->get();

        $usuario = User::find($autorizadores[0]->autorizador_id);
        switch ($opcion){
            case 1: //SUBIR DE RANGO
                //ASIGNAR USUARIOS
                foreach ($usuario->solicitantes as $solicitante){
                    $array_responsable = [
                        'autorizador_id'=>$id,
                        'solicitante_id'=>$solicitante->id
                    ];
                    $responsable = Responsable::create($array_responsable);
                    $responsable->save();
                }

                $usuario = User::find($id);
                $usuario->rol_id = 5;
                $usuario->save();

                break;
            case 2: //BAJAR DE RANGO
                //VERIFICA QUE EXISTA MINIMAMENTE UN AUTORIZADOR
                if(count($autorizadores)>1){ //EXISTEN MAS AUTORIZADORES
                    $solicitantes = Responsable::where('autorizador_id','=',$id)
                        ->get();
                    foreach ($solicitantes as $solicitante){
                        $solicitante->delete();
                    }

                    $usuario = User::find($id);
                    $usuario->rol_id = 6;
                    $usuario->save();
                }else{ //SOLO QUEDA UN AUTORIZADOR
                    return redirect()->back()
                        ->withErrors(["No se puede completar la accion debido a que minimamente deberia haber un autorizador para el equipo"]);
                }
                break;
        }

        Session::flash('success', "Usuario ".$usuario->username." cambio correctamente...");
        return redirect()->back();

    }
}
