@extends('layouts.pdf')

@section('content')
    <div class="pull-right">
        <img width="164px" height="60px" src="{{ asset('images/tepco_srl.jpg') }}">
    </div>
    <table class="table table-bordered table-condensed">
        <tbody>
        <tr>
            <th rowspan="2" class="text-center" width="30%;" style="vertical-align: middle; font-size: 16px; background-color: #c0e674;">INFORME DE PEDIDOS SIN FINALIZAR</th>
            <th width="6%;">Fecha</th>
            <td width="8%;">{{Carbon\Carbon::now()->toDateString() }}</td>
            <th width="6%;">Hora</th>
            <td width="4%;">{{ Carbon\Carbon::now()->toTimeString() }}</td>
        </tr>
        <tr>
            <th width="4%;"># Pedidos</th>
            <td colspan="3" width="15%;" class="text-center">{{count($pedidos)}}</td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">
                Responsable: <span style="font-weight: normal;">
                    {{$responsable}}
                </span>
            </td>
        </tr>

        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th colspan="5" style="background-color: #c0e674;" class="text-center">LISTADO DE PEDIDOS EN ESTADO "ASIGNADO"</th>
        </tr>
        <tr>
            <th width="3%;">#</th>
            <th width="10%;">Codigo</th>
            <th width="34%;">Solicitante</th>
            <th width="33%;">Responsable</th>
            <th width="20%;">Creado en:</th>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS TEMPORALES -->
        @php $aux=1;@endphp
        @foreach($pedidos as $pedido)
            <tr>
                <th scope="row">{{$aux}}</th>
                <td>{{$pedido->codigo}}</td>
                <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                <td>{{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->nombres}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_1}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_2}}
                </td>
                <td>{{$pedido->created_at}}</td>
            </tr>
            @php $aux++;@endphp
        @endforeach
        </tbody>
    </table>


    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th colspan="5" style="background-color: #c0e674;" class="text-center">LISTADO DE PEDIDOS EN ESTADO "PARCIALES PENDIENTES"</th>
        </tr>
        <tr>
            <th width="3%;">#</th>
            <th width="10%;">Codigo</th>
            <th width="34%;">Solicitante</th>
            <th width="33%;">Responsable</th>
            <th width="20%;">Creado en:</th>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS TEMPORALES -->
        @php $aux=1;@endphp
        @foreach($pedidos_parciales as $pedido)
            <tr>
                <th scope="row">{{$aux}}</th>
                <td>{{$pedido->codigo}}</td>
                <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                <td>{{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->nombres}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_1}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_2}}
                </td>
                <td>{{$pedido->created_at}}</td>
            </tr>
            @php $aux++;@endphp
        @endforeach
        </tbody>
    </table>


    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th colspan="5" style="background-color: #c0e674;" class="text-center">LISTADO DE PEDIDOS EN ESTADO "DESPACHADO"</th>
        </tr>
        <tr>
            <th width="3%;">#</th>
            <th width="10%;">Codigo</th>
            <th width="34%;">Solicitante</th>
            <th width="33%;">Responsable</th>
            <th width="20%;">Creado en:</th>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS TEMPORALES -->
        @php $aux=1;@endphp
        @foreach($pedidos_despachados as $pedido)
            <tr>
                <th scope="row">{{$aux}}</th>
                <td>{{$pedido->codigo}}</td>
                <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                <td>{{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->nombres}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_1}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_2}}
                </td>
                <td>{{$pedido->created_at}}</td>
            </tr>
            @php $aux++;@endphp
        @endforeach
        </tbody>
    </table>


    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th colspan="5" style="background-color: #c0e674;" class="text-center">LISTADO DE PEDIDOS EN ESTADO "ESPERA"</th>
        </tr>
        <tr>
            <th width="3%;">#</th>
            <th width="10%;">Codigo</th>
            <th width="34%;">Solicitante</th>
            <th width="33%;">Responsable</th>
            <th width="20%;">Creado en:</th>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS TEMPORALES -->
        @php $aux=1;@endphp
        @foreach($pedidos_espera as $pedido)
            <tr>
                <th scope="row">{{$aux}}</th>
                <td>{{$pedido->codigo}}</td>
                <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                <td>{{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->nombres}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_1}} {{$pedido->asignados_nombres_with_trashed[count($pedido->asignados_nombres_with_trashed)-1]->empleado_nombres->apellido_2}}
                </td>
                <td>{{$pedido->created_at}}</td>
            </tr>
            @php $aux++;@endphp
        @endforeach
        </tbody>
    </table>
@endsection