<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Codigo</th>
        <th>Salida</th>
        <th>Num. Ped. Emp.</th>
        <th>Empresa</th>
        <th>Proyecto</th>
        <th>Area</th>
        <th>Num. Ot.</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody id="tbodySalidas">
        @foreach($salidas as $salida)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $salida->pedido->codigo }}</td>
            <td>{{ $salida->id }}</td>
            <td>{{$salida->num_solicitud}}</td>
            <td>{{ $salida->pedido->proyecto->empresa->nombre }}</td>
            <td>{{ $salida->pedido->proyecto->nombre }}</td>
            <td>{{ $salida->area }}</td>
            <td>{{ $salida->num_ot }}</td>
            <td>
                <a href="{{route('salidas.pdf',$salida->id)}}" target="_blank" class="btn btn-sm btn-info-custom" title="Imprimir pedido {{ $salida->pedido->codigo }}"><i class="fa fa-print"></i> </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>