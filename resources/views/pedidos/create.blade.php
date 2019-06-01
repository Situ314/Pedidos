@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => 'pedidos.store', 'files'=>true, 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask', 'autocomplete' => 'off') ) }}

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
                <div class="x_title">
                    <h2>Documento <small>De ser necesario se debe agregar documentos <strong> (el tamaño máximo permitido es 50 mb)</strong></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <button type="button" class="btn btn-success-custom" onclick="javascript:agregarDocumento();"><i class="fa fa-plus"></i> Agregar Documentos</button>
                    <div id="advertencia_size" hidden class="alert alert-danger alert-dismissible fade in" role="alert">
                        No se puede agregar el archivo, el tamaño máximo permitido es 50 MB.
                    </div>
                    @include('pedidos.parts.docs-table')
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
                    <div id="contenedor-table" class="table-responsive">
                        @include('pedidos.parts.items-table')
                    </div>
                    <button id="btnAgregarItem" type="button" onclick="agregarItem();" class="btn btn-sm btn-success-custom pull-left" disabled="true" title="Primero seleccione un tipo de categoria">
                        <i class="fa fa-plus"> </i> Agregar Item
                    </button>
                    <br>
                    <div class="ln_solid"></div>
                    <div class="row text-center">
                        <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fa fa-arrow-left"> </i> Volver</a>
                        {{-- SI TIENE EMPLEADO --}}
                        @if(count(\Illuminate\Support\Facades\Auth::user()->empleado) != 0)
                            <button type="submit" class="btn btn-success-custom"><i class="fa fa-save"> </i> Guardar</button>
                        @else
                            <button class="btn btn-success-custom" disabled="true"><i class="fa fa-save" title="No puede realizar esta accion"> Guardar</i></button>
                        @endif
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
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/create-p.js') }}
    {{ Html::script('/js/items/buscar-item.js') }}
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
                    unidades: {!! json_encode($unidades->toArray()) !!},
                    items: {!! json_encode($items->toArray()) !!},
                    tipos: {!! json_encode($tipos->toArray()) !!},
                    tipo_compras: {!! json_encode($tipo_compras->toArray()) !!}
                }
            ]
        };

    </script>
@endsection