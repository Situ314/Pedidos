@extends('layouts.mail')

@section('content-title')
    INFORME DE PEDIDOS SIN FINALIZAR DE {{$responsable}}
@endsection
@section('content-message')
    <h3>Estimado:
        {{$receptor}}
    </h3>
    <span>
       {{--Mediante la presenta se adjunta el listado de los pedidos en estado {{$tipo}} del responsable {{$responsable}}.<br/>A continuación se detalla el listado:--}}
        <pre>{{$mensaje}}</pre>
    </span>
    {{--<span>--}}
        {{--<table>--}}
            {{--<thead style="border: #2a3f54 2px">--}}
                {{--<tr>--}}
                     {{--<th width="3%;">#</th>--}}
                    {{--<th width="10%;">Codigo</th>--}}
                    {{--<th width="60%;">Solicitante</th>--}}
                    {{--<th width="20%;">Creado en:</th>--}}
                {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@php $aux=1;@endphp--}}
            {{--@foreach($pedidos as $pedido)--}}
                {{--<tr style="border: #2a3f54 2px">--}}
                    {{--<th scope="row">{{$aux}}</th>--}}
                    {{--<td>{{$pedido->codigo}}</td>--}}
                    {{--<td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>--}}
                    {{--<td>{{$pedido->created_at}}</td>--}}
                {{--</tr>--}}
            {{--@php $aux++;@endphp--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</span>--}}
    <hr/>
    <span style="size: 10px">
      Atentamente<br>
        Lic. Martin Lara Plaza<br>
        <i>alara@pragmainvest.com.bo</i><br>
        <i>Corto: 5000</i>
    </span>
@endsection
