@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    <input name="pedido_id" value="{{$pedido->id}}" hidden>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Datos del pedido <small>Algunos datos relevantes del pedido</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="form-group">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-user"></i> Solicitante</label>
                            <p>{{$pedido->solicitante->empleado->nombres}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-file-text"></i> Motivo/Descripción</label>
                            <p>{{$pedido->estados_pedido[0]->motivo }}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-calendar"></i> Fecha de pedido</label>
                            <p>{{$pedido->created_at}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-sort-numeric-asc"></i> Codigo</label>
                            <p>{{$pedido->codigo}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-institution"></i> Empresa</label>
                            <p>{{$pedido->proyecto->empresa->nombre}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-institution"></i> Proyecto</label>
                            <p>{{$pedido->proyecto->nombre}}</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    {{--<div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items Solicitados <small>Tabla con los items pedidos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="table-responsive">
                        @include('responsable.parts.items-pedidos')
                    </div>
                </div>
            </div>

        </div>
    </div>--}}
    {{ Form::open( array('route' => ['responsable.update',$pedido->id], 'method' => 'PUT','class' => 'form-horizontal form-label-left input_mask') ) }}
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items A Entregar <small>Tabla con los items a entregar</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="table-responsive">
                        @include('responsable.parts.items-entregados')
                    </div>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="pull-left">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> Volver</i></a>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger-custom" onclick="javascript:modalDevolver(3);"><i class="fa fa-pause"></i> En Espera</button>
                            <button type="button" class="btn btn-primary-custom" onclick="javascript:modalDevolver(2);"><i class="fa fa-eye"></i> Observar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"> Guardar</i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{ Form::close() }}


    {{ Form::select( 'tipo_cat_id', $tipos->pluck('nombre','id'), array(null) ) }}

    <!-- MODAL DEVOLUCION -->
    @include('modals.modal-devolucion')

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}

    {{ Html::script('/js/pedidos/edit-p.js') }}
    {{ Html::script('/js/pedidos/edit-responsable.js') }}


    {{ Html::script('/js/pedidos/agregar-item-boton-asignador.js') }}
    {{ Html::script('/js/devolucion.js') }}

    <script type="text/javascript">

        var config = {
            rutas:[
                {
                    token: "{{Session::token()}}"
                }
            ],
            variables:[
                {
                    categorias: {!! json_encode($categroias->toArray()) !!},
                    unidades: {!! json_encode($unidades->toArray()) !!},
                    items: {!! json_encode($items->toArray()) !!},
                    categoriaSelect: {{$pedido->tipo_categoria_id}},
                    cantItemEntrega: {{count($pedido->items_entrega)}},
                    items_entrega: {!! json_encode($pedido->items_entrega) !!}

                }
            ]
        };
    </script>
@endsection