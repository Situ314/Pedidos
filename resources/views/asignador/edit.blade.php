@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => 'asignaciones.store', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}
    <input name="pedido_id" value="{{$pedido->id}}" hidden>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Asignación <small>Formulario para la asignación del pedido</small></h2>
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
                            <label for="motivo" class="control-label"><i class="fa fa-user"></i> Usuario</label>
                            <p>{{$pedido->estados_pedido[ count($pedido->estados_pedido)-1]->usuario->empleado->nombres }}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-file-text"></i> Motivo/Descripción</label>
                            <p>{{$pedido->estados_pedido[0]->motivo }}</p>
                        </div>

                    </div>
                    @include('asignador.form')
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items <small>Tabla con los items a pedir</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="table-responsive">
                        @include('asignador.parts.items-table')
                    </div>
                    <button id="btnAgregarItem" type="button" onclick="javascritp:agregarItem();" class="btn btn-sm btn-success-custom pull-left" disabled="true" title="Primero seleccione un tipo de categoria">
                        <i class="fa fa-plus"> Agregar Item</i>
                    </button>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="pull-left">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> Volver</i></a>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger-custom" onclick="javascript:modalDevolver(1);"><i class="fa fa-close"></i> Rechazar</button>
                            <button type="button" class="btn btn-primary-custom" onclick="javascript:modalDevolver(2);"><i class="fa fa-eye"></i> Observar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"> Asignar</i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{Form::close()}}

    <!-- MODAL DEVOLUCION -->
    @include('modals.modal-devolucion')

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}

    {{ Html::script('/js/pedidos/edit-p.js') }}
    {{ Html::script('/js/pedidos/edit-asignador.js') }}


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
                    cantItemTemp: {{count($pedido->items_temp_pedido)}},
                    cantItem: {{count($pedido->items_pedido)}},
                    item_pedido: {!! json_encode($pedido->items_pedido) !!},
                    item_pedido_temp: {!! json_encode($pedido->items_temp_pedido) !!}
                }
            ]
        };
    </script>
@endsection