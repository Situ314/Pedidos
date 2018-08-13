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
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Lista de Pedidos</h3>
            </div>

            {{--<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input id="txtBuscarPedido" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button" onclick="javascript:buscarPedido();"><i class="fa fa-search"></i></button>
                    </span>
                    </div>
                </div>
            </div>--}}
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><i class="fa fa-location-arrow"></i> Pedidos <small>Pedidos realizados</small></h2>
                        <a class="btn btn-md btn-success-custom pull-right" href="{{route('pedidos.create')}}"><i class="fa fa-plus"></i> Crear</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-pills nav-pills-index">
                                @php
                                    switch (\Illuminate\Support\Facades\Auth::user()->rol_id){
                                        case 1:
                                            $auxObs = 0;
                                            $auxRech = 0;
                                            foreach ($estados as $estado){
                                                if($estado->id == 1){
                                                echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                }else{
                                                    echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                }
                                            }
                                            break;
                                        case 2:
                                            break;
                                        case 3:
                                            foreach ($estados as $estado){
                                                if($estado->id!=1){
                                                    if($estado->id == 2){
                                                    echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                    }else{
                                                    echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                    }
                                                }
                                            }
                                            break;
                                        case 4:
                                            foreach ($estados as $estado){
                                                if($estado->id>=2){
                                                    if($estado->id == 2){
                                                        echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                    }else{
                                                        echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                    }
                                                }
                                            }
                                            break;
                                        case 5:
                                            foreach ($estados as $estado){
                                                if($estado->id == 1){
                                                echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                }else{
                                                    if($estado->id != 3){
                                                        echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                    }
                                                }
                                            }
                                            break;
                                        case 6:
                                            foreach ($estados as $estado){
                                                if($estado->id == 1){
                                                echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                }elseif($estado->id >= 2){
                                                echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                                }
                                            }
                                            break;
                                    }
                                @endphp
                                <li role="presentation" class="pull-right">
                                    <a href="#busqueda-tab" role="tab" data-toggle="tab" aria-expanded="true"><i class="fa fa-search"></i>BUSQUEDA</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content" style="margin-top: 10px;">
                                <div id="contenido-tab" class="table-responsive">
                                </div>
                            </div>
                        </div>

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
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            pedidos: "{{route('pedidos.estados')}}",
            cantidad: "{{route('pedidos.cantidad')}}",
            buscar: "{{route('pedidos.buscar')}}",
            getItem: "{{route('pedidos.items')}}",
            getEstado: "{{route('pedidos.progreso')}}",
            editPedido: "{{route('pedidos.edit',['id'=>':id'])}}",
            procesoPedido: "{{route('pedidos.proceso')}}",
            verificacion: "{{route('verificacion.show',['id'=>':id'])}}",
            verificacionAutorizador: "{{route('autorizador.show',['id'=>':id'])}}",
            verificacionResponsable: "{{route('responsable.edit',['id'=>':id'])}}",
            asignadorEdit: "{{route('asignaciones.edit',['id'=>':id'])}}",

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
            token: "{{Session::token()}}"
        };
        var variables = {
            estados: {!! json_encode($estados) !!},
            uR: {{ \Illuminate\Support\Facades\Auth::user()->rol_id }}
        };
    </script>
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/index-p.js') }}
    {{ Html::script('/js/set-tab-index.js') }}
    {{ Html::script('/js/archivos/readeble-size.js') }}

@endsection