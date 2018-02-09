@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    {{ Form::open( array('route' => 'pedidos.store', 'files'=>true, 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}

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
                    <h2>Documento <small>Formulario que permite subir documentos si son necesarios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <button type="button" class="btn btn-success-custom" onclick="javascript:agregarDocumento();"><i class="fa fa-plus"></i> Agregar Documentos</button>
                    @include('pedidos.parts.docs-table')
                    {{--<div id="hide" class="col-lg-8 col-xs-8">
                        <label class="hand-cursor">
                            <input name="doc[]" type="file" nv-file-select uploader="$ctrl.uploader"/>
                            <span class="fa fa-camera"></span>
                            <span class="photo_text hidden-xs">Photo</span>
                        </label>
                    </div>--}}
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
                        {{-- SI TIENE EMPLEADO --}}
                        @if(count(\Illuminate\Support\Facades\Auth::user()->empleado) != 0)
                            <button type="submit" class="btn btn-success-custom"><i class="fa fa-save"> Guardar</i></button>
                        @else
                            <button class="btn btn-success-custom" disabled="true"><i class="fa fa-save" title="No puede realizar esta accion"> Guardar</i></button>
                        @endif
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
    {{ Html::script('/js/archivos/readeble-size.js') }}

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
                    tipos: {!! json_encode($tipos->toArray()) !!}
                }
            ]
        };

    </script>
@endsection