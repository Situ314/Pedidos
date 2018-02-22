<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Autorizador</th>
        <th>Equipo</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($autorizadores as $autorizador)
    <tr>
        <th scope="row" width="2%;">{{ $loop->iteration }}</th>
        <td>
            @if(count($autorizador->empleado)>0)
                {{ $autorizador->empleado->nombre_completo }} ({{$autorizador->username}})
            @else
                {{$autorizador->username}}
            @endif
        </td>
        <td>
            @foreach($autorizador->solicitantes as $solicitante)
                @if(count($solicitante->empleado)>0)
                    <img src="{{asset('images/user.png')}}" width="32" height="32" title="{{$solicitante->empleado->nombre_completo}}">
                @else
                    <img src="{{asset('images/user.png')}}" width="32" height="32" title="{{$solicitante->username}}">
                @endif
            @endforeach
        </td>
        <td>
            <a href="{{route('admin-autorizadores.equipo',$autorizador->id)}}" class="btn btn-info-custom" onclick="verSolicitantes({{$autorizador->id}})" title="Ver usuarios de {{$autorizador->username}}"><i class="fa fa-users"></i></a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>