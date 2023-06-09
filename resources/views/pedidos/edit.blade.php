@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => ['pedidos.update',$pedido->id], 'files'=>true, 'method' => 'PUT','class' => 'form-horizontal form-label-left input_mask', 'autocomplete' => 'off') ) }}

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
                <div class="x_title">
                    <h2>Documentos <small>Ya subidos al crear</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @if(count($documentos) == 0)
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <strong><i class="fa fa-check"></i></strong> No hay documentos subidos
                        </div>
                    @else
                        <table id="tableDocSubidos" class="table table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Documento</th>
                                <th>Tipo</th>
                                <th>Opciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $auxItem=0;@endphp
                            @foreach($documentos as $doc)
                                <tr>
                                    <td>{{$auxItem+1}}</td>
                                    <td>{{$doc->nombre}}</td>
                                    <td>{{$doc->mime}}</td>
                                    <td><a href="{{route('doc.descargar',$doc->id)}}" class="btn btn-success-custom" title="Descargar {{$doc->nombre}}"><i class="fa fa-download"></i></a></td>
                                </tr>
                                @php $auxItem++; @endphp
                            @endforeach
                            </tbody>
                        </table>
                     @endif
                </div>

                <div class="x_title">
                    <h2>Documento <small>De ser necesario puede agregar más documentos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <button type="button" class="btn btn-success-custom" onclick="javascript:agregarDocumentoEdit();"><i class="fa fa-plus"></i> Agregar Documentos</button>
                    @include('pedidos.parts.docs-table-edit')
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
                    <button id="btnAgregarItem" type="button" onclick="javascritp:agregarItem();" class="btn btn-sm btn-success-custom pull-left" disabled="true" title="Primero seleccione un tipo de categoria">
                        <i class="fa fa-plus"> </i> Agregar Item
                    </button>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="row text-center">
                        <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> </i> Volver</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"> </i> Guardar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{Form::close()}}

    <!-- MODALS -->
    @include('pedidos.modals.modal-buscar-item')

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/edit-p.js') }}
    {{ Html::script('/js/pedidos/edit-edit-p.js') }}
    {{ Html::script('/js/pedidos/agregar-item-boton.js') }}
    {{ Html::script('/js/archivos/readeble-size.js') }}
    <!-- JS CON FUNCION DE BUSQUEDA, MODAL DE BUSQUEDA ITEM-->
    {{ Html::script('/js/pedidos/buscar-item.js') }}

    <script type="text/javascript">

        @php $bandera = true; @endphp

        @if(count(\Illuminate\Support\Facades\Auth::user()->empleado) != 0)
            {{-- SI TIENE USUARIO EN SOLICITUDES --}}
            @if(count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud) != 0)
                {{-- SI PROYECTOS RELACIONADOS CON EL USUARIO --}}
                @if( count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos)!=0 )
                    var proyectos_solicitudes =
                    {
                        pr: {!! json_encode(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos) !!}
                    };
                    @foreach(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos as $proyecto)
                    @if($proyecto->id == \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->id)
                    @php $bandera = false; @endphp
                    @endif
                    @endforeach

                    @if($bandera)
                        var proyectos_empleado = {
                                pr: {!! json_encode(\Illuminate\Support\Facades\Auth::user()->empleado->proyecto) !!}
                            };
                                @else
                        var proyectos_empleado = {};
                    @endif
                @endif
            @endif
        @endif

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
                    estados_tic: {!! json_encode($estadotic->toArray()) !!},
                    unidades: {!! json_encode($unidades->toArray()) !!},
                    items: {!! json_encode($items->toArray()) !!},
                    proyectoPedido: {{$pedido->proyecto_id}},
                    categoriaSelect: {{$pedido->tipo_categoria_id}},
                    cantItemTemp: {{count($pedido->items_temp_pedido)}},
                    cantItem: {{count($pedido->items_pedido)}},
                    item_pedido: {!! json_encode($pedido->items_pedido) !!},
                    item_pedido_temp: {!! json_encode($pedido->items_temp_pedido) !!},
                    tipo_compras: {!! json_encode($tipo_compras->toArray()) !!}
                }
            ]
        };
    </script>
@endsection