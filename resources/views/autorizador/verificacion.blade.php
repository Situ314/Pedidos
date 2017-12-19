@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pedido <small>Datos del pedido</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p><b><i class="fa fa-calendar"></i> Fecha de pedido: </b></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p>{{$pedido->created_at}}</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p><b><i class="fa fa-sort-numeric-asc"></i> Codigo: </b></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p>{{$pedido->codigo}}</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p><b><i class="fa fa-institution"></i> Empresa: </b></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p>{{$pedido->proyecto->empresa->nombre}}</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p><b><i class="fa fa-institution"></i> Proyecto: </b></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p>{{$pedido->proyecto->nombre}}</p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p><b><i class="fa fa-user"></i> Solicitante: </b></p>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                            <p>{{$pedido->solicitante->empleado->nombres}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items<small>items pedidos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                {{ Form::open( array('route' => 'verificacion.store', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}
                <input name="tipo_categoria_id" hidden value="{{ $pedido->tipo_categoria_id }}">
                <input name="pedido_id" hidden value="{{ $pedido->id }}">
                <div class="x_content">
                    <div class="row">

                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $aux=1;@endphp
                        @foreach($pedido->items_temp_pedido as $item)
                            <tr>
                                <th scope="row">@php echo $aux; $aux++@endphp</th>
                                <td><p>{{$item->item->nombre}}</p></td>
                                <td><p>{{$item->cantidad}}</p></td>
                                <td><p>{{$item->item->unidad->full_name}}</p></td>
                            </tr>
                        @endforeach
                        @foreach($pedido->items_pedido as $item)
                            <tr>
                                <th scope="row">@php echo $aux; $aux++@endphp</th>
                                <td><p>{{$item->item->nombre}}</p></td>
                                <td><p>{{$item->cantidad}}</p></td>
                                <td><p>{{$item->item->unidad->full_name}}</p></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="pull-left">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> Volver</i></a>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger-custom" onclick="javascript:modalDevolver(1);"><i class="fa fa-close"></i> Rechazar</button>
                            <button type="button" class="btn btn-primary-custom" onclick="javascript:modalDevolver(2);"><i class="fa fa-eye"></i> Observar</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Autorizar</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- MODAL RECHAZAR -->
    @include('modals.modal-devolucion')
@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/verific.js') }}
@endsection