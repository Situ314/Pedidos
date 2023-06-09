<?php

namespace App\Http\Controllers;

use App\Empleado;
use App\Responsable;
use App\Rol;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Response;
use Session;
class UsersController extends Controller
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
        $roles = Rol::all();
        $autorizadores = User::where('rol_id','=',5)
            ->get();
        $empleados = Empleado::where('estado','=','Activo')
            ->get();

        if(Auth::user()->rol_id == 2){ //USUARIO ADMINISTRADOR
            $usuarios = $usuarios
                ->where('rol_id','>',2);
            $roles = $roles
                ->where('id','>',2);
        }
        $usuarios = $usuarios->get();

        return view('admin.users.index')
            ->withUsers($usuarios)
            ->withRoles($roles)
            ->withAutorizadores($autorizadores)
            ->withEmpleados($empleados);
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
        $this->validate($request, array(
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8'
        ));

        $array_user = [
            'username'=>$request->username,
            'password'=>bcrypt($request->password),
            'empleado_id'=>$request->empleado_id,
            'rol_id'=>$request->rol_id
        ];
        $usuario = new User($array_user);
        $usuario->save();

        if($request->rol_id == 6){ //SE CREA UN USUARIO
            $array_responsable = [
                'autorizador_id'=>$request->autorizador_id,
                'solicitante_id'=>$usuario->id
            ];
            $responsable = new Responsable($array_responsable);
            $responsable->save();
        }

        if($request->rol_id==5){ //CUANDO ES AUTORIZADOR SE GENERA EL MISMO
            $array_responsable = [
                'autorizador_id'=>$usuario->id,
                'solicitante_id'=>$usuario->id
            ];
            $responsable = new Responsable($array_responsable);
            $responsable->save();
        }


        Session::flash('success', "Usuario ".$usuario->username." creado correctamente...");
        return redirect()->back();
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
        $user = User::find($id);

        $user->empleado;
        $responsables = Responsable::where('solicitante_id','=',$id)->first();

        return Response::json(
            [$user,
            $responsables]
        );
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
//        $this->validate($request, array(
//            'password' => 'required|min:8'
//        ));

        $usuario = User::find($id);
        $usuario->username = $request->username;
//        $usuario->password = bcrypt($request->password);
        $usuario->empleado_id = $request->empleado_id;
        $usuario->rol_id = $request->rol_id;
        if ($usuario->rol_id != 5 || $request->rol_id == 5){ //SI USUARIO - VERIFICAR AUTORIZADOR
            $responsable = new Responsable();

            $responsable -> autorizador_id = $id;
            $responsable -> solicitante_id = $id;

            $responsable->save();
            
        }
        $usuario->update();


        if ($usuario->rol_id == 6){ //SI USUARIO - VERIFICAR AUTORIZADOR
            $responsable = Responsable::where('solicitante_id','=',$usuario->id)
                ->first();

            if($responsable!=null){
                if($responsable->autorizador_id != $request->autorizador_id){ //CAMBIO DE AUTORIZADOR
                    $responsable->autorizador_id = $request->autorizador_id;
                    $responsable->update();
                }
            }else{ //CREAR RESPONSABLE
                $array_responsable = [
                    'autorizador_id'=>$request->autorizador_id,
                    'solicitante_id'=>$usuario->id
                ];
                $responsable = new Responsable($array_responsable);
                $responsable->save();
            }

        }

        Session::flash('success', "Usuario ".$usuario->username." modificado correctamente...");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $error = true;
        $nombre = User::find($id)->username;
        try{
            User::destroy($id);
            $error = false;
            Session::flash('success', "Usuario ".$nombre." deshabilitado...");

        }catch (\Exception $e){
            $error = true;
            Session::flash('success', "Usuario ".$nombre." deshabilitado...");
        }

        return Response::json(
            $error
        );
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id){
        $error = true;

        try{
            User::withTrashed()->find($id)->restore();
            $error = false;
            Session::flash('success', "Usuario  habilitado...");

        }catch (\Exception $e){
            $error = true;
        }

        return Response::json(
            $error
        );
    }

    /**
     * Update password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, array(
            'password' => 'required|min:8',
            'password_repeat' => 'required|same:password',
        ));

        $usuario = User::find($id);
        $usuario->password = bcrypt($request->password);
        $usuario->update();

        Session::flash('success', "Contraseña del usuario ".$usuario->username." modificada correctamente...");
        return redirect()->back();
    }
}
