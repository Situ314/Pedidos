@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => 'pedidos.store', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Creación de Pedido <small>Formulario para la realización de un pedido</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    @include('pedidos.form')
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
                    <div id="alertBuscarNombrePedido">
                    </div>
                    <br>
                    <div class="table-responsive">
                        @include('pedidos.parts.items-table')
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
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/create-p.js') }}
    {{ Html::script('/js/items/buscar-item.js') }}


    <script type="text/javascript">

        var config = {
            rutas:[
                {
                    buscarItem: "{{route('buscar.item')}}",
                    token: "{{Session::token()}}"
                }
            ],
            variables:[
                {
                    categorias: {!! json_encode($categroias->toArray()) !!},
                    unidades: {!! json_encode($unidades->toArray()) !!},
                    items: {!! json_encode($items->toArray()) !!}
                }
            ]
        };
    </script>
@endsection