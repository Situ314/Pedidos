<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Usuario</th>
        <th>Autorizadores</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row" width="2%;">{{$loop->iteration}}</th>
                <td>
                    @if(count($user->empleado)>0)
                        {{$user->empleado->nombre_completo}} ({{$user->username}})
                    @else
                        {{$user->username}}
                    @endif
                </td>
                <td>
                    @foreach($user->autorizadores as $autorizador)
                        @if(count($autorizador->empleado)>0)
                            <img src="{{asset('images/user.png')}}" width="32" height="32" title="{{$autorizador->empleado->nombre_completo}}">
                        @else
                            <img src="{{asset('images/user.png')}}" width="32" height="32" title="{{$autorizador->username}}">
                        @endif
                    @endforeach
                </td>
                <td>
                    @if($user->deleted_at == null)
                        <button type="button" class="btn btn-info-custom" onclick="editarAutorizadores({{$user->id}});" title="Editar autorizadores"><i class="fa fa-user-secret"></i></button>
                    @else
                        <label class="label label-danger">Usuario deshabilitado</label>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>