<?php

namespace App\Http\Controllers;

use App\Responsable;
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
