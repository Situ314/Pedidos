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
                    <h2>Creación de Pedido <small>formulario para la realización de un pedido</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    @include('pedidos.form')

                    <div class="ln_solid"></div>


                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items <small>tabla con los items a pedir</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="table-responsive">
                        @include('pedidos.items-table')
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><span class="fa fa-arrow-left"> Volver</span></a>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"> Guardar</span></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{Form::close()}}

@endsection

@section('footerScripts')
    {{ Html::script('/js/select2.min.js') }}
    {{ Html::script('/js/pedidos/create-p.js') }}

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
                    unidades: {!! json_encode($unidades->toArray()) !!}
                }
            ]
        };
    </script>
@endsection