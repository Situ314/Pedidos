@extends('layouts.pdf')

@section('content')
    <table class="table table-bordered table-condensed">
        <tbody>
        <tr>
            <th width="8%;">Empresa</th>
            <td width="15%;">{{ $salida->proyecto->empresa->nombre }}</td>
            <th rowspan="2" class="text-center" width="30%;" style="vertical-align: middle; font-size: 16px;">SALIDA DE ALMACEN</th>
            <th width="4%;">N°</th>
            <td colspan="3" width="15%;" class="text-center">N° {{ $salida->id }}</td>
        </tr>
        <tr>
            <th>O.T. <span style="font-weight: normal;">{{ $salida->num_ot }}</span></th>
            <td style="font-weight: bold;"># Solicitud <span style="font-weight: normal;">{{$salida->pedido->num_solicitud}}</span></td>
            <th width="6%;">Fecha</th>
            <td width="8%;">{{ date( "Y-m-d",strtotime($salida->created_at) ) }}</td>
            <th width="6%;">Hora</th>
            <td width="4%;">{{ date( "h::i",strtotime($salida->created_at) ) }}</td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">
                Solicitado por: <span style="font-weight: normal;">{{ $salida->pedido->solicitante->empleado->nombre_completo }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">
                Para el area de: <span style="font-weight: normal;">{{ $salida->area }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="9" style="font-weight: bold;">
                Proyecto: <span style="font-weight: normal;">{{ $salida->proyecto->nombre }}</span>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th colspan="5">DATOS DE LOS PRODUCTOS</th>
            </tr>
            <tr>
                <th width="4%;">Item</th>
                <th width="40%;">Detalle</th>
                <th width="10%;">Cantidad</th>
                <th width="6%;">U.M.</th>
                <th width="40%;">Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salida->salida_items as $salida_item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $salida_item->item_pedido_entregado->item->nombre }}</td>
                <td>{{ $salida_item->cantidad }}</td>
                <td>{{ $salida_item->item_pedido_entregado->item->unidad->nombre }}</td>
                <td>{{ $salida_item->observacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead>
            <th>ENTREGUE CONFORME ALMACEN</th>
            <th>COURRIER, DELIVERY O CHOFER</th>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="row text-center">
                        <p>FIRMA</p>
                        <br>
                        <br>
                        <p>___________________________________</p>
                    </div>
                    <div class="row" style="margin: 0px 0px 0px 0px;">
                        <p><span style="font-weight: bold;">Nombre:</span> {{ $salida->responsable->nombre_completo }}</p>
                        <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->responsable->ci_numero }}</p>
                        <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->responsable->ci_numero }}</p>
                    </div>
                </td>
                <td>d</td>
            </tr>
        </tbody>
    </table>
@endsection