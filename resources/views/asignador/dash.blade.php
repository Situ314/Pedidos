@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
    <style type="text/css" rel="stylesheet">
        @media screen and (max-width: 480px) {
            .nav {
                padding-left:2px;
                padding-right:2px;
            }
            .nav li {
                display:block !important;
                width:100%;
                margin:0px;
            }
            .nav li.active {
                border-bottom:1px solid #ddd!important;
                margin: 0px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="form-group">
                <label class="control-label col-md-3" for="first-name">Seleccione a un Responsable:
                </label>
                <div class="col-md-8">
                    <select id="responsables-select" name="responsable_id" class="js-placeholder-single" required="true">
                        <option selected="selected" value="0">TODOS LOS RESPONSABLES</option>
                        @foreach($responsables as $responsable)
                            <option value="{{$responsable->id}}">{{$responsable->empleado->nombres}} {{$responsable->empleado->apellido_1}} {{$responsable->empleado->apellido_2}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <button type="button" onclick="getPedidosResponsable()" class="btn btn-success-custom"><i class="fa fa-eye"></i> Ver</button>
            <a type="button" id="print-todo" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-primary-custom" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
            <a type="button" id="email-todo" onclick="abrirModalEmail('0')" class="btn btn-info-custom"><i class="fa fa-envelope-o" target="_blank"></i> Enviar</a>
        </div>
    </div>
    <div style="margin-bottom: 10px" id="contenido">
    </div>
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2 id="titulo-asignados">Pedidos Asignados ({{count($pedidos)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="print-asignados" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank">
                            <i class="fa fa-print"></i></a>
                        </li>
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="email-asignados" onclick="abrirModalEmail()" class="btn-sm btn-info-custom" target="_blank"><i class="fa fa-envelope-o"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    <div id="table-pedido" class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2 id="titulo-parciales">Pedidos Parciales Pendientes ({{count($pedidos_parciales)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="print-pendientes" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank">
                                <i class="fa fa-print"></i></a></button>
                        </li>
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="email-pendientes" onclick="abrirModalEmail()" class="btn-sm btn-info-custom" target="_blank"><i class="fa fa-envelope-o"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    <div id="table-pedido-parciales" class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2 id="titulo-despachados">Pedidos Despachados ({{count($pedidos_despachados)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="print-despachados" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank">
                                <i class="fa fa-print"></i></a>
                        </li>
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="email-despachados" onclick="abrirModalEmail()" class="btn-sm btn-info-custom" target="_blank"><i class="fa fa-envelope-o"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    <div id="table-pedido-despachados" class="table-responsive">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2 id="titulo-espera">Pedidos En Espera ({{count($pedidos_espera)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="print-espera" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank">
                                <i class="fa fa-print"></i></a>
                        </li>
                        <li><a style="padding: 8px;padding-left: 10px; padding-right: 10px" id="email-espera" onclick="abrirModalEmail()" class="btn-sm btn-info-custom" target="_blank"><i class="fa fa-envelope-o"></i></a>
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    <div id="table-pedido-espera" class="table-responsive">

                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @include('pedidos.modals.modal-items')
    @include('pedidos.modals.modal-estados')
    @include('responsable.modal-en-proceso')
    @include('modals.modal-salidas')
    @include('pedidos.modals.modal-documentos')
    @include('modals.modal-completar')
    @include('asignador.modals.modal-enviar-email')
    @include('asignador.modals.modal-enviar-responsable')
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            pedidos: "{{route('pedidos.pedidosxresp')}}",
            token: "{{Session::token()}}",
            getItem: "{{route('pedidos.items')}}",
            getEstado: "{{route('pedidos.progreso')}}",
            editPedido: "{{route('pedidos.edit',['id'=>':id'])}}",
            procesoPedido: "{{route('pedidos.proceso')}}",
            verificacion: "{{route('verificacion.show',['id'=>':id'])}}",
            verificacionAutorizador: "{{route('autorizador.show',['id'=>':id'])}}",
            verificacionResponsable: "{{route('responsable.edit',['id'=>':id'])}}",
            asignadorEdit: "{{route('asignaciones.edit',['id'=>':id'])}}",

            //PEDIDOS IMPRESION
            impSol: "{{route('impimir.pedido.solicitados',':id')}}",
            impEnt: "{{route('impimir.pedido.entregados',':id')}}",
            impInf: "{{route('imprimir.responsable.informe',':id')}}",

            //SALIDAS
            salidas: "{{route('salida.alm')}}",
            salidasEdit: "{{route('salidas.edit',['id'=>':id'])}}",
            pdf: "{{route('salidas.pdf',['id'=>':id'])}}",

            //DOCUMENTOS
            docStor: "{{route('documento.store')}}",
            storage: "{{ asset('storage/archivo') }}",
            docGet: "{{route('doc.get',['id'=>':id'])}}",
            docPed: "{{route('post.docs')}}",
            descDoc: "{{route('doc.descargar',['id'=>':id'])}}",
            //COMP.P
            comP: "{{route('responsable.completar',['id'=>':id'])}}",

            //CORREO
            correo: "{{route('correo.responsable.informe.personal')}}",
            informe: "{{route('correo.responsable.informe')}}"
        };
    </script>
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/asignador-dash.js') }}


@endsection