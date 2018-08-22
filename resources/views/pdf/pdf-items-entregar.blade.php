@extends('layouts.pdf')

@section('content')
    <div class="pull-right">
        <img width="164px" height="60px" src="http://solicitudes.pragmainvest.com.bo/empresas/tepco_srl/tepco_srl.jpg">
    </div>
    <table class="table table-bordered table-condensed">
        <tbody>
        <tr>
            <th width="8%;">Empresa</th>
            <td width="18%;">{{$pedido->proyecto->empresa->nombre}}</td>
            <th rowspan="2" class="text-center" width="30%;" style="vertical-align: middle; font-size: 16px; background-color: #c0e674;">ITEMS A ENTREGAR</th>
            <th width="4%;">Codigo</th>
            <td colspan="3" width="15%;" class="text-center">{{$pedido->codigo}}</td>
        </tr>
        <tr>
            <th># Pedido<span style="font-weight: normal;"></span></th>
            <td style="font-weight: bold;"><span style="font-weight: normal;">{{$pedido->id}}</span></td>
            <th width="6%;">Fecha</th>
            <td width="8%;">{{ date( "Y-m-d",strtotime($pedido->updated_at) ) }}</td>
            <th width="6%;">Hora</th>
            <td width="4%;">{{ date("H:i",strtotime($pedido->updated_at)) }}</td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">
                Solicitado por: <span style="font-weight: normal;">
                    @if(count($pedido->solicitante->empleado) > 0)
                        {{$pedido->solicitante->empleado->nombre_completo}}
                    @else
                        {{$pedido->solicitante->username}}
                    @endif
                </span>
            </td>
        </tr>

        <tr>
            <td colspan="9" style="font-weight: bold;">
                Proyecto: <span style="font-weight: normal;"> {{$pedido->proyecto->nombre}}</span>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th colspan="5" style="background-color: #c0e674;">LISTADO DE ITEMS A ENTREGAR</th>
        </tr>
        <tr>
            <th width="4%;">Item</th>
            <th width="60%;">Detalle</th>
            <th width="10%;">Cantidad</th>
            <th width="6%;">U.M.</th>
            <th width="10%;">TIPO</th>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS TEMPORALES -->
        @php $aux=1;@endphp
        @foreach($pedido->items_entregar as $item)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td>{{$item->nombre}}</td>
                <td>{{$item->pivot->cantidad}}</td>
                <td>{{$item->unidad->nombre}}</td>
                <td>REGISTRADO</td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection