@extends('layouts.pdf')

@section('content')
    {{$pedido}}
    <table class="table table-bordered table-condensed table-responsive">
        <tbody>
        <tr>
            <th width="10%;">Empresa</th>
            <td>{{$pedido->proyecto->empresa->nombre}}</td>
            <th rowspan="2" class="text-center" style="vertical-align: middle; font-size: 20px;">SALIDA DE ALMACEN</th>
            <th width="4%;">N°</th>
            <td colspan="3"></td>
        </tr>
        <tr>
            <th>O.T.
            <td>{{$pedido->salidas_almacen[0]->num_ot}}</td>
            <th width="6%;">Fecha</th>
            <td></td>
            <th width="6%;">Hora</th>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" style="font-weight: bold;">
                Solicitado por: <span id="txtSolicitanteSalida" style="font-weight: normal !important;"></span>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="font-weight: bold;">
                Para el area de: <span id="txtAreaSalida" style="font-weight: normal !important;"></span>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="font-weight: bold;">
                Proyecto: <span id="txtProyectoSalida" style="font-weight: normal !important;"></span>
            </td>
        </tr>
        </tbody>
    </table>
@endsection