@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Items<small>items que necesitan ser verificados</small></h2>
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
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Precio (Bs.)</th>
                            <th>Tipo</th>
                        </tr>
                        </thead>
                        <tbody>
                            @php $aux=1;@endphp
                            @foreach($pedido->items_temp_pedido as $item)
                                <tr>
                                    <th scope="row">@php echo $aux; $aux++@endphp</th>
                                    <td><input name="item_pedido_id[]" class="hidden" value="{{$item->id}}"><input name='txtItemTemp[]' type='text' class='form-control input-hg-12 items-txt text-uppercase' value="{{$item->item->nombre}}"/></td>
                                    <td>{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
                                    <td>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'js-placeholder-single', 'required'=>'true']) }}</td>
                                    <td>{{ Form::number('precio[]', null, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
                                    <td><span class="label label-warning">Item temporal</span></td>
                                </tr>
                            @endforeach
                            @foreach($pedido->items_pedido as $item)
                                <tr>

                                <th scope="row">@php echo $aux; $aux++@endphp</th>
                                <td><input name="item_pedido_id[]" class="hidden" value="{{$item->id}}">{{$item->item->nombre}}</td>
                                    <td><input name='txtItemTemp[]' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' value=""/>{{ Form::number('cantidad[]', $item->cantidad, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
                                    <td>{{ Form::select('unidad_id[]', $unidades->pluck('full_name', 'id'), $item->item->unidad_id, ['class'=>'js-placeholder-single', 'required'=>'true','disabled']) }}</td>
                                    <td>{{ Form::number('precio[]', $item->item->precio_unitario, ['class'=>'form-control input-hg-12', 'step'=>'0.1','required'=>'true']) }}</td>
                                    <td><span class="label label-success">Item registrado</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="text-center">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><span class="fa fa-arrow-left"> Volver</span></a>
                            <button type="submit" class="btn btn-success"><span class="fa fa-save"> Guardar</span></button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('footerScripts')
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/verificar-p.js') }}

@endsection