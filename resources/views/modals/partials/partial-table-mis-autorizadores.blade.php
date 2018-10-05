<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre Completo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($autorizadores as $autorizador)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$autorizador->empleado->nombre_completo}}</td>
            </tr>
        @endforeach
    </tbody>
</table>