@extends('layouts.main')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Lista de Salidas</h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <input id="txtBuscarSalida" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                    {{--<div class="input-group">
                        <input id="txtBuscarPedido" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                        <span class="input-group-btn">
                           <button class="btn btn-default" type="button" onclick="javascript:buscarPedidoSalida();"><i class="fa fa-search"></i></button>
                        </span>
                    </div>--}}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-sign-out"></i> Salidas <small>Listado de pedidos con salidas para impresión</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if(count($salidas) > 0)
                            @include('responsable.impresiones.table-salidas-pedidos')
                        @else
                            <p>No cuenta con ninguna salida para su impresión</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/responsable/salida-p.js') }}

@endsection