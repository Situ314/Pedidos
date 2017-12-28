@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => ['pedidos.update',$pedido->id], 'method' => 'PUT','class' => 'form-horizontal form-label-left input_mask') ) }}

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Actualización del Pedido <small>Formulario para la actualización de un pedido</small></h2>
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
                            <p>{{$pedido->estados_pedido[ count($pedido->estados_pedido)-1]->motivo }}</p>
                        </div>

                    </div>
                    @include('pedidos.form-edit')
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
                        @include('pedidos.parts.items-table-edit')
                    </div>
                    <button id="btnAgregarItem" type="button" onclick="javascritp:agregarItem();" class="btn btn-sm btn-success-custom pull-right" disabled="true" title="Primero seleccione un tipo de categoria">
                        <i class="fa fa-plus"> Agregar Item</i>
                    </button>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="row text-center">
                        <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> Volver</i></a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"> Guardar</i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{Form::close()}}

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}

    {{ Html::script('/js/pedidos/edit-p.js') }}
    {{ Html::script('/js/pedidos/edit-edit-p.js') }}


    {{ Html::script('/js/pedidos/agregar-item-boton.js') }}

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