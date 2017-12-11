@extends('layouts.app')

@section('content')
    <div style="margin: 60px 20px 50px 20px;">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right top_search">
                {{ Form::open( array('route' => ['pedidos.buscar','buscar'=>':buscar'], 'method' => 'GET','data-parsley-validate' => '','class'=>'form-group validate-form','id'=>'formBuscar') ) }}
                <div class="input-group">
                    <input name="codigo" type="text" value="{{$codigo}}" class="form-control" placeholder="Codigo...">
                    <span class="input-group-btn">
                  <button id="btnBuscar" class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                </span>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pedido <small> Con codigo {{$codigo}}</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(count($pedido)!=0)
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                @foreach($estados as $estado)
                                    <li>
                                        @foreach($estadosp as $p)
                                            @if($estado->id == $p->estado_id)
                                                <a class="selected">
                                            @else
                                                <a class="disabled">
                                            @endif
                                        @endforeach
                                            <span class="step_no">{{$estado->id}}</span>
                                            <span class="step_descr">
                                              {{$estado->nombre}}<br>
                                              <small>{{$estado->descripcion}}</small>
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <h2>Listado</h2>
                        <div id="wizard_verticle" class="form_wizard wizard_verticle">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $aux = 1; @endphp
                                @foreach($pedido->items_pedido as $item)
                                    <tr>
                                        <th scope="row">@php echo $aux; $aux++; @endphp</th>
                                        <td>{{$item->item->nombre}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td>{{$item->item->unidad->full_name}}</td>
                                    </tr>
                                @endforeach

                                @foreach($pedido->items_temp_pedido as $item)
                                    <tr>
                                        <th scope="row">@php echo $aux; $aux++; @endphp</th>
                                        <td>{{$item->item->nombre}}</td>
                                        <td>{{$item->cantidad}}</td>
                                        <td>{{$item->item->unidad->full_name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <p>No se encontro ningun pedido con ese codigo</p>
                    @endif
            </div>
        </div>
        </div>
        @if(count($pedido)!=0)
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Solicitud <small>datos del solicitante</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="">
                            <ul class="list-unstyled msg_list">
                                <li>
                                    <a>
                                        <span>Solicitante</span>
                                        <span class="message">
                                      {{$pedido->solicitante->nombres}}
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Generado <small>realización</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <ul class="list-unstyled msg_list">
                                <li>
                                    <a>
                                        <span>Realizado por</span>
                                        <span class="message">
                                      {{$pedido->estados_pedido[0]->usuario->empleado->nombres}}
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            $('#btnBuscar').on('click',function (e) {
                e.preventDefault();
                var action = $('#formBuscar').attr('action').replace(':buscar',$('input[name=codigo]').val());
                $('#formBuscar').attr('action',action).submit();
            });
        });
    </script>
@endsection