@extends('layouts.mail')

@section('content-title')
    INFORME DE PEDIDO SIN FINALIZAR ({{$pedido->codigo}})
@endsection
@section('content-message')
    <h3>Estimado:
        Carlos Daniel Arteaga
    </h3>
    <span>
       Se ruega atender de manera <strong>inmediata</strong>, el siguiente Pedido, mismo que cuenta con los siguientes detalles: <br>
        <br>
        <strong>CÓDIGO: </strong> {{$pedido->codigo}} <br>
        <strong>SOLICITANTE: </strong> {{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}  <br>
        <strong>EMPRESA: </strong> {{$pedido->proyecto_empresa->empresa->nombre}} <br>
        <strong>CREADO EN: </strong> {{$pedido->created_at}} <br>
    </span>

    <span>
        <table>
        <thead>
        <tr>
        <th width="3%;">#</th>
        <th width="60%;">Item</th>
        <th width="10%;">Cantidad</th>
        <th width="14%;">Unidad</th>
        <th width="13%;">Tipo</th>
        </tr>
        </thead>
        <tbody>
        @php $aux=1;@endphp
        @foreach($pedido->items_pedido as $item)
        <tr>
            <th scope="row">{{$aux}}</th>
            <td>{{$item->item->nombre}}</td>
            <td>{{$item->cantidad}}</td>
            <td>{{$item->item->unidad->nombre}}</td>
            <td>Item Registrado</td>
        </tr>
        @php $aux++;@endphp
        @endforeach

        @foreach($pedido->items_temp_pedido as $item)
            <tr style="border: #2a3f54 2px">
            <th scope="row">{{$aux}}</th>
            <td>{{$item->item->nombre}}</td>
            <td>{{$item->cantidad}}</td>
            <td>{{$item->item->unidad->nombre}}</td>
            <td>Item Temporal</td>
        </tr>
            @php $aux++;@endphp
        @endforeach
        </tbody>
        </table>
    </span>
    {{--<span style="size: 10px">--}}
      {{--Atentamente<br>--}}
        {{--Lic. Martin Lara Plaza<br>--}}
        {{--<i>alara@pragmainvest.com.bo</i><br>--}}
        {{--<i>Corto: 5000</i>--}}
    {{--</span>--}}
@endsection
@section('content-optional')
    <span style="size: 10px">
    Atentamente<br>
    Lic. Martin Lara Plaza<br>
    <i>alara@pragmainvest.com.bo</i><br>
    <i>Corto: 5000</i>
    </span>
@endsection