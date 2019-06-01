@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    @php $contadorTic = 0; @endphp
    <input name="pedido_id" value="{{$pedido->id}}" hidden>
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Pedido <strong>{{$pedido->codigo}}  </strong> <small>Algunos datos relevantes del pedido</small></h2>
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
                            <p id="txtSolicitante">{{$pedido->solicitante->empleado->nombre_completo}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-file-text"></i> Motivo/Descripción</label>
                            @if($pedido->estados_pedido[count($pedido->estados_pedido)-1]->motivo == null)
                                <p>CUMPLIR EL PEDIDO</p>
                            @else
                                <p>{{$pedido->estados_pedido[count($pedido->estados_pedido)-1]->motivo }}</p>
                            @endif
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-calendar"></i> Fecha de pedido</label>
                            <p>{{$pedido->created_at}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-institution"></i> Empresa</label>
                            <p id="txtEmpresa">{{$pedido->proyecto->empresa->nombre}}</p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-home"></i> Proyecto</label>
                            @if(count($pedido->proyecto->padre)>0)
                                <p>{{$pedido->proyecto->padre->nombre}} &#10148 {{$pedido->proyecto->nombre}}</p>
                            @else
                                <p>{{$pedido->proyecto->nombre}}</p>
                            @endif
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="motivo" class="control-label"><i class="fa fa-briefcase"></i> Oficina</label>
                            @if($pedido->oficina != null)
                                <p id="txtEmpresa">{{$pedido->oficina->direccion}}</p>
                            @else
                                <p id="txtEmpresa"> SIN ESPECIFICAR</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 11)
        {{ Form::open( array('route' => ['responsable.update.tic',$pedido->id], 'method' => 'PUT','class' => 'form-horizontal form-label-left input_mask', 'id' => 'formUpdateResponsableTic') ) }}
    @else
        {{ Form::open( array('route' => ['responsable.update',$pedido->id], 'method' => 'PUT','class' => 'form-horizontal form-label-left input_mask', 'id' => 'formUpdateResponsable') ) }}
    @endif
    <input name="num_solicitud" hidden>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                        <h2>Salida de Almacen <small>Formulario de salida de almacen</small></h2>
                    @else
                        <h2>Datos de Entrega <small>Formulario de entrega</small></h2>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                        @include('responsable.form')
                    @else
                        @include('responsable.form-tic')
                    @endif
                </div>
            </div>

        </div>
    </div>
    {{--@php $contadorTic=0; @endphp--}}
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
                        @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                            @include('responsable.parts.items-entregados')
                        @else
                            @include('responsable.parts.items-entregados-tics')
                        @endif
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 11)
                        @php
                            foreach($pedido->items_entrega as $item){
                                $contadorTic = $contadorTic + $item->cantidad;
                            }
                        @endphp
                        <button id="btnAgregarItem" type="button" onclick="javascritp:agregarItemTic();" class="btn btn-sm btn-success-custom pull-left" disabled="true" title="Primero seleccione un tipo de categoria">
                            <i class="fa fa-plus"> </i>Agregar Item
                        </button>
                    @endif
                    <br>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="pull-left">
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> Volver</i></a>
                        </div>
                        <div class="pull-right">
                            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                            <button type="button" class="btn btn-warning-custom" onclick="javascript:modalDevolver(3);"><i class="fa fa-pause"></i> En Espera</button>
                            <button type="button" class="btn btn-danger-custom" onclick="javascript:modalDevolver(1);"><i class="fa fa-close"></i> Rechazar</button>
                            @endif
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"> </i> Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{ Form::close() }}
@php
 if($pedido->oficina_id == null){
    $ofi = '1';
 }else{
    $ofi = $pedido->oficina_id;
 }
@endphp

    {{ Form::select( 'tipo_cat_id', $tipos->pluck('nombre','id'), array(null),['style'=>'visibility:hidden'] ) }}

    <!-- MODAL DEVOLUCION -->
    @include('modals.modal-devolucion')
    @include('responsable.modal-salida-almacen')
    @include('responsable.modal-salida-almacen-tic')
    @include('modals.modal-informacion')

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}

    {{ Html::script('/js/pedidos/edit-p.js') }}
    {{ Html::script('/js/pedidos/edit-responsable.js') }}

    {{ Html::script('/js/pedidos/agregar-item-boton-responsable-tic.js') }}
    {{ Html::script('/js/devolucion.js') }}

    <script type="text/javascript">

       var config = {
            rutas:[
                {
                    salidaMax: "{{ route('salida.id.max') }}",
                    token: "{{Session::token()}}"
                }
            ],
            variables:[
                {
                    categorias: {!! json_encode($categroias->toArray()) !!},
                    unidades: {!! json_encode($unidades->toArray()) !!},
                    items: {!! json_encode($items->toArray()) !!},
                    tipo_compras: {!! json_encode($tipo_compras->toArray()) !!},
                    estados_tic: {!! json_encode($estadotic->toArray()) !!},
                    categoriaSelect: {{$pedido->tipo_categoria_id}},
                    proyectoPedido: {{$pedido->proyecto_id}},

                    //ITEMS ENTREGA
                    cantItemEntrega: {{count($pedido->items_entrega)}},
                    cantItemEntregaTic: {{$contadorTic}},
                    items_entrega: {!! json_encode($pedido->items_entrega) !!},

                    proy: {!! json_encode($proyectos->toArray()) !!},
                    emp: {{ $pedido->proyecto->empresa_id }},
                    pr: {{ $pedido->proyecto->id }},
                    ofi: {{ $ofi }},
                    ped: {{ $pedido->id }},
                    usu: {{\Illuminate\Support\Facades\Auth::id()}}
                }
            ]
        };
    </script>
@endsection