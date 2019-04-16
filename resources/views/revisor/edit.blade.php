@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => 'revisor.store', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}
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
                            <p>{{$pedido->estados_pedido[ count($pedido->estados_pedido)-1]->usuario->empleado->nombres }} {{$pedido->estados_pedido[ count($pedido->estados_pedido)-1]->usuario->empleado->apellido_1 }}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-file-text"></i> Motivo/Descripción</label>
                            <p>{{$pedido->estados_pedido[0]->motivo }}</p>
                        </div>

                    </div>
                    @include('revisor.form')
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
                        @include('revisor.parts.items-table')
                    </div>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="pull-left">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Volver</a>
                        </div>
                        <div class="pull-right">
                            {{--<button type="button" class="btn btn-danger-custom" onclick="javascript:modalDevolver(1);"><i class="fa fa-close"></i> Rechazar</button>--}}
                            {{--<button type="button" class="btn btn-primary-custom" onclick="javascript:modalDevolver(2);"><i class="fa fa-eye"></i> Observar</button>--}}
                            <button type="submit" class="btn btn-success"><i class="fa fa-arrow-right"></i> Aprobar</button>
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

    {{ Html::script('/js/pedidos/edit-revisor.js') }}
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
                    categorias: {!! json_encode($categorias->toArray()) !!},
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