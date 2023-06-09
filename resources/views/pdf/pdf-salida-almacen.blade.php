@extends('layouts.pdf')

@section('content')
    <div class="pull-right">
        <img width="164px" height="60px" src="{{ asset('images/tepco_srl.jpg') }}">
    </div>
    <table class="table table-bordered table-condensed">
        <tbody>
        <tr>
            <th width="8%;">Empresa</th>
            <td width="18%;">{{ $salida->proyecto->empresa->nombre }}</td>
            <th rowspan="2" class="text-center" width="30%;" style="vertical-align: middle; font-size: 16px; background-color: #c0e674;">SALIDA DE ALMACEN</th>
            <th width="6%;">Nº</th>
            <td width="4%;">{{ $salida->id }}</td>
            <th width="6%;">Cod.</th>
            <td width="8%;">{{ $salida->pedido->codigo }}</td>
        </tr>
        <tr>
            <th>O.T. <span style="font-weight: normal;">{{ $salida->num_ot }}</span></th>
            <td style="font-weight: bold;"># Pedido: <span style="font-weight: normal;">{{$salida->num_solicitud}}</span></td>
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
                @if($salida->proyecto->padre != null)
                    Proyecto: <span style="font-weight: normal;">{{ $salida->proyecto->padre->nombre }} > {{ $salida->proyecto->nombre }}</span>
                @else
                    Proyecto: <span style="font-weight: normal;">{{ $salida->proyecto->nombre }}</span>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th colspan="5" style="background-color: #c0e674;">DATOS DE LOS PRODUCTOS</th>
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
        <thead style="background-color: #c0e674;">
            <th>ENTREGUE CONFORME ALMACEN</th>
            <th>COURRIER, DELIVERY O CHOFER</th>
        </thead>
        <tbody>
            <tr>
                <td width="50%;">
                    <div class="row text-center">
                        <p>FIRMA</p>
                        <br>
                        <br>
                        <p>___________________________________</p>
                    </div>
                    <div class="row" style="margin: 0px 0px 0px 0px;">
                        <p><span style="font-weight: bold;">Nombre:</span> {{ $salida->responsable->empleado->nombre_completo }}</p>
                        <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->responsable->empleado->ci_numero }}</p>
                        <p><span style="font-weight: bold;">Cargo:</span> {{ $salida->responsable->empleado->laboral_empleado->cargo->nombre }}</p>
                        <p>Fecha: ........../........../..........  Hora..........::..........</p>
                    </div>
                </td>
                <td width="50%;">
                    @if($salida->courrier_id != null)
                        <div class="row text-center">
                            <p>FIRMA</p>
                            <br>
                            <br>
                            <p>___________________________________</p>
                        </div>
                        <div class="row" style="margin: 0px 0px 0px 0px;">
                            <p><span style="font-weight: bold;">Nombre:</span> {{ $salida->courrier->nombre_completo }}</p>
                            <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->courrier->ci_numero }}</p>
                            <p><span style="font-weight: bold;">Cargo:</span> {{ $salida->courrier->laboral_empleado->cargo->nombre }}</p>
                            <p>Fecha: ........../........../..........  Hora..........::..........</p>
                        </div>
                    @else
                        <div class="row text-center">
                            <p>FIRMA</p>
                            <br>
                            <br>
                            <p>___________________________________</p>
                        </div>
                        <div class="row" style="margin: 0px 0px 0px 0px;">
                            <p><span style="font-weight: bold;">Nombre:</span></p>
                            <p><span style="font-weight: bold;">C.I.:</span></p>
                            <p><span style="font-weight: bold;">Cargo:</span></p>
                            <p>Fecha: ........../........../..........  Hora..........::..........</p>
                        </div>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <table class="table table-bordered table-condensed">
        <thead style="background-color: #c0e674;">
        <th>COURRIER, DELIVERY O CHOFER</th>
        <th>RECIBI CONFORME DESTINATARIO FINAL</th>
        </thead>
        <tbody>
        <tr>
            <td width="50%;">
                @if($salida->courrier_id != null)
                    <div class="row text-center">
                        <p>FIRMA</p>
                        <br>
                        <br>
                        <p>___________________________________</p>
                    </div>
                    <div class="row" style="margin: 0px 0px 0px 0px;">
                        <p><span style="font-weight: bold;">Nombre:</span> {{ $salida->courrier->nombre_completo }}</p>
                        <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->courrier->ci_numero }}</p>
                        <p><span style="font-weight: bold;">Cargo:</span> {{ $salida->courrier->laboral_empleado->cargo->nombre }}</p>
                        <p>Fecha: ........../........../..........  Hora..........::..........</p>
                    </div>
                @else
                    <div class="row text-center">
                        <p>FIRMA</p>
                        <br>
                        <br>
                        <p>___________________________________</p>
                    </div>
                    <div class="row" style="margin: 0px 0px 0px 0px;">
                        <p><span style="font-weight: bold;">Nombre:</span></p>
                        <p><span style="font-weight: bold;">C.I.:</span></p>
                        <p><span style="font-weight: bold;">Cargo:</span></p>
                        <p>Fecha: ........../........../..........  Hora..........::..........</p>
                    </div>
                @endif
            </td>
            <td width="50%;">
                <div class="row text-center">
                    <p>FIRMA</p>
                    <br>
                    <br>
                    <p>___________________________________</p>
                </div>
                <div class="row" style="margin: 0px 0px 0px 0px;">
                    <p><span style="font-weight: bold;">Nombre:</span> {{ $salida->pedido->solicitante->empleado->nombre_completo }}</p>
                    <p><span style="font-weight: bold;">C.I.:</span> {{ $salida->pedido->solicitante->empleado->ci_numero }}</p>
                    <p><span style="font-weight: bold;">Cargo:</span> {{ $salida->pedido->solicitante->empleado->laboral_empleado->cargo->nombre }}</p>
                    <p>Fecha: ........../........../..........  Hora..........::..........</p>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
@endsection