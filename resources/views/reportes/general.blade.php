@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
    <style type="text/css" rel="stylesheet">
        @media screen and (max-width: 480px) {
            .nav {
                padding-left:2px;
                padding-right:2px;
            }
            .nav li {
                display:block !important;
                width:100%;
                margin:0px;
            }
            .nav li.active {
                border-bottom:1px solid #ddd!important;
                margin: 0px;
            }
        }
    </style>
@endsection

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-file-text-o"></i> Reporte General</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Filtros <small>(Elija los filtros que requiera)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="empresa-select"><i class="fa fa-building-o"></i> EMPRESA: </label>
                                <div class="col-md-9">
                                    <select id="empresa-select" name="empresa_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODAS LOS EMPRESAS</option>
                                        @foreach($empresas as $empresa)
                                            <option value="{{$empresa->id}}">{{$empresa->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="estado-select"><i class="fa fa-check-square-o"></i> ESTADO: </label>
                                <div class="col-md-9">
                                    <select id="estado-select" name="estado_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LOS ESTADOS</option>
                                        @foreach($estados as $estado)
                                            <option value="{{$estado->id}}">{{$estado->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="usuario-select"><i class="fa fa-user"></i> SOLICITANTE: </label>
                                <div class="col-md-9">
                                    <select id="usuario-select" name="usuario_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LOS SOLICITANTES</option>
                                        @foreach($usuarios as $usuario)
                                            <option value="{{$usuario->id}}">{{$usuario->empleado->nombres}} {{$usuario->empleado->apellido_1}} {{$usuario->empleado->apellido_2}} ({{$usuario->username}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="autorizador-select"><i class="fa fa-user-secret"></i> AUTORIZADOR: </label>
                                <div class="col-md-9">
                                    <select id="autorizador-select" name="empresa_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LOS AUTORIZADORES</option>
                                        @foreach($autorizadores as $autorizador)
                                            <option value="{{$autorizador->id}}">{{$autorizador->empleado->nombres}} {{$autorizador->empleado->apellido_1}} {{$autorizador->empleado->apellido_2}}({{$autorizador->username}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="responsable-select"><i class="fa fa-users"></i> RESPONSABLE: </label>
                                <div class="col-md-9">
                                    <select id="responsable-select" name="empresa_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LOS RESPONSABLES</option>
                                        @foreach($responsables as $responsable)
                                            <option value="{{$responsable->id}}">{{$responsable->empleado->nombres}} {{$responsable->empleado->apellido_1}} {{$responsable->empleado->apellido_2}}({{$responsable->username}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="categoria-select"><i class="fa fa-shopping-cart"></i> CATEGORÍA: </label>
                                <div class="col-md-9">
                                    <select id="categoria-select" name="empresa_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LAS CATEGORÍAS</option>
                                        @foreach($tipos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="item-select"><i class="fa fa-shopping-basket"></i> PRODUCTO: </label>
                                <div class="col-md-9">
                                    <select id="item-select" name="empresa_id" class="js-placeholder-single">
                                        <option selected="selected" value="0">TODOS LOS PRODUCTOS</option>
                                        @foreach($items as $item)
                                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-12"><i class="fa fa-sign-in"></i> FECHA DE SOLICITUD: </label>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="desde-select"><i class="fa fa-calendar"></i> DESDE: </label>
                                <div class="col-md-9">
                                    <input id="desde-select" placeholder="" class="form-control form-admin" name="fecha_ini" type="date" value="">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="form-group row col-md-12">
                                <label class="control-label col-md-3" for="hasta-select"><i class="fa fa-calendar"></i> HASTA: </label>
                                <div class="col-md-9">
                                    <input id="hasta-select" placeholder="" class="form-control form-admin" name="fecha_ini" type="date" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="row">--}}
                        {{--<div class="col-md-2 col-sm-2 col-xs-12">--}}
                            {{--<div class="form-group row col-md-12">--}}
                                {{--<label class="control-label col-md-12"><i class="fa fa-check-square-o"></i> FECHA DE ENTREGA: </label>--}}

                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-md-5 col-sm-5 col-xs-12">--}}
                            {{--<div class="form-group row col-md-12">--}}
                                {{--<label class="control-label col-md-3" for="desde-select"><i class="fa fa-calendar"></i> DESDE: </label>--}}
                                {{--<div class="col-md-9">--}}
                                    {{--<input id="desde-entrega-select" placeholder="" class="form-control form-admin" name="fecha_ini" type="date" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-md-5 col-sm-5 col-xs-12">--}}
                            {{--<div class="form-group row col-md-12">--}}
                                {{--<label class="control-label col-md-3" for="hasta-select"><i class="fa fa-calendar"></i> HASTA: </label>--}}
                                {{--<div class="col-md-9">--}}
                                    {{--<input id="hasta-entrega-select" placeholder="" class="form-control form-admin" name="fecha_ini" type="date" value="">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="row">
                        <div style="text-align: center" class="col-md-12 col-sm-12 col-xs-12">
                            <button type="button" onclick="filtrar()" class="btn btn-primary-custom"><i class="fa fa-search"></i> FILTRAR</button>
                            <button type="button" onclick="excel()" class="btn btn-success-custom"><i class="fa fa-file-excel-o"></i> EXPORTAR A EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pop-excel"></div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2 id="titulo-contador">Resultado <strong>({{count($pedidos)}} Registos obtenidos)</strong><small>obtenido</small></h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div style="margin-bottom: 5px" id="tags-filtro">
                    </div>
                    <div id="contenido-filtro" class="table-responsive">
                    {{--<table class="table table-striped jambo_table bulk_action">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th style="color: white">#</th>--}}
                            {{--<th style="color: white">Código</th>--}}
                            {{--<th style="color: white">Empresa</th>--}}
                            {{--<th style="color: white">Proyecto</th>--}}
                            {{--<th style="color: white">Solicitante</th>--}}
                            {{--<th style="color: white">Asignado a:</th>--}}
                            {{--<th style="color: white">Creado en:</th>--}}
                            {{--<th style="color: white">Estado</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--@php--}}
                            {{--$num = 1;--}}
                        {{--@endphp--}}
                        {{--@foreach($pedidos as $pedido)--}}
                            {{--@php--}}
                                {{--$estado = $pedido->estados->sortByDesc('id')->first();--}}
                                {{--$estado_completo = 'nada';--}}
                                {{--$label = "";--}}
                                {{--$icon = "";--}}
                               {{--// echo $estado;--}}
                                {{--if($estado == null){--}}
                                    {{--$status = "";--}}
                                {{--}else{--}}
                                    {{--$status = $estado->nombre;--}}
                                    {{--$status_id = $estado->id;--}}
                                    {{--$estado_completo = 'nada';--}}
                                    {{--switch ($status_id){--}}
                                        {{--case 1:--}}
                                            {{--$label = 'label-info';--}}
                                            {{--break;--}}
                                        {{--case 2:--}}
                                            {{--$label = 'label-primary';--}}
                                            {{--break;--}}
                                        {{--case 3:--}}
                                            {{--$label = 'label-info';--}}
                                            {{--$icon ='fa-user';--}}
                                            {{--break;--}}
                                        {{--case 4:--}}
                                            {{--$label = 'label-warning';--}}
                                            {{--break;--}}
                                        {{--case 5:--}}
                                            {{--$label = 'label-warning';--}}
                                            {{--$icon ='fa-paper-plane';--}}
                                            {{--break;--}}
                                        {{--case 6:--}}
                                            {{--$label = 'label-warning';--}}
                                            {{--$icon ='fa-eye';--}}
                                            {{--break;--}}
                                        {{--case 7:--}}
                                            {{--$label = 'label-danger';--}}
                                            {{--break;--}}
                                        {{--case 8:--}}
                                            {{--$label = 'label-success';--}}
                                            {{--$icon ='fa-check';--}}
                                            {{--break;--}}
                                        {{--case 9:--}}
                                            {{--$label = 'label-warning';--}}
                                            {{--$icon ='fa-clock-o';--}}
                                            {{--break;--}}
                                    {{--}--}}
                                {{--}--}}
                           {{--// echo $estado_completo;--}}
                            {{--@endphp--}}
                            {{--<tr>--}}
                                {{--<td>{{$num++}}</td>--}}
                                {{--<td>{{$pedido->codigo}}</td>--}}
                                {{--<td>{{$pedido->proyecto_empresa->empresa->nombre}}</td>--}}
                                {{--<td>{{$pedido->proyecto->nombre}}</td>--}}
                                {{--<td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>--}}
                                {{--<td>{{$pedido->asignados_nombres_with_trashed->first()['empleado_nombres']['nombres']}} {{$pedido->asignados_nombres->first()['empleado_nombres']['apellido_1']}} {{$pedido->asignados_nombres->first()['empleado_nombres']['apellido_2']}}</td>--}}
                                {{--<td>{{$pedido->created_at}}</td>--}}
                                {{--<td><span class="label {{$label}}"><i class="fa {{$icon}}"></i> {{$status}}</span></td>--}}
                            {{--</tr>--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales -->
@include('pedidos.modals.modal-items')
@include('pedidos.modals.modal-estados')
@include('responsable.modal-en-proceso')
@include('modals.modal-salidas')
@include('pedidos.modals.modal-documentos')
@include('modals.modal-completar')
@endsection

@section('footerScripts')
    @parent
    <script>


        var rutas = {
            pedidos: "{{route('reporte.filtrado')}}",
            cantidad: "{{route('pedidos.cantidad')}}",
            excel: "{{route('reporte.excel')}}",
            buscar: "{{route('pedidos.buscar')}}",
            buscarItem: "{{route('pedidos.buscaritem')}}",
            getItem: "{{route('pedidos.items')}}",
            getEstado: "{{route('pedidos.progreso')}}",
            editPedido: "{{route('pedidos.edit',['id'=>':id'])}}",
            procesoPedido: "{{route('pedidos.proceso')}}",
            verificacion: "{{route('verificacion.show',['id'=>':id'])}}",
            verificacionAutorizador: "{{route('autorizador.show',['id'=>':id'])}}",
            verificacionResponsable: "{{route('responsable.edit',['id'=>':id'])}}",
            asignadorEdit: "{{route('asignaciones.edit',['id'=>':id'])}}",

            //PEDIDOS IMPRESION
            impSol: "{{route('impimir.pedido.solicitados',':id')}}",
            impEnt: "{{route('impimir.pedido.entregados',':id')}}",

            //SALIDAS
            salidas: "{{route('salida.alm')}}",
            salidasEdit: "{{route('salidas.edit',['id'=>':id'])}}",
            pdf: "{{route('salidas.pdf',['id'=>':id'])}}",

            //DOCUMENTOS
            docStor: "{{route('documento.store')}}",
            storage: "{{ asset('storage/archivo') }}",
            docGet: "{{route('doc.get',['id'=>':id'])}}",
            docPed: "{{route('post.docs')}}",
            descDoc: "{{route('doc.descargar',['id'=>':id'])}}",
            //COMP.P
            comP: "{{route('responsable.completar',['id'=>':id'])}}",
            token: "{{Session::token()}}"
        };


    </script>
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/reportes/reporte-general.js') }}
@endsection