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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-location-arrow"></i> Pedidos <small>Pedidos realizados</small></h2>
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
                                        break;
                                    case 5:
                                        foreach ($estados as $estado){
                                            if($estado->id == 1){
                                            echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                            }else{
                                            echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                            }
                                        }
                                        break;
                                    case 6:
                                        foreach ($estados as $estado){
                                            if($estado->id == 1){
                                            echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                            }elseif($estado->id > 2){
                                            echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.' <span id="'.$estado->id.'-tab-cantidad" class="badge">0</span></a></li>';
                                            }
                                        }
                                        break;
                                }
                            @endphp
                            {{--@foreach($estados as $estado)
                                @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                                    @if($estado->id==2)
                                        <li role="presentation" class="active"><a href="#tab{{$estado->id}}" id="{{$estado->id}}-tab" role="tab" data-toggle="tab" aria-expanded="true">{{$estado->nombre}}</a>
                                        </li>
                                    @endif
                                    @if($loop->last)
                                        <li role="presentation" class=""><a href="#tab{{$estado->id}}" role="tab" id="{{$estado->id}}-tab" data-toggle="tab" aria-expanded="false">{{$estado->nombre}}</a>
                                        </li>
                                    @endif
                                @else
                                    @if($loop->iteration==1)
                                        <li role="presentation" class="active"><a href="#tab{{$estado->id}}" id="{{$estado->id}}-tab" role="tab" data-toggle="tab" aria-expanded="true">{{$estado->nombre}}</a>
                                        </li>
                                    @else
                                        @if(\Illuminate\Support\Facades\Auth::user()->rol_id < 4)
                                            <li role="presentation" class=""><a href="#tab{{$estado->id}}" role="tab" id="{{$estado->id}}-tab" data-toggle="tab" aria-expanded="false">{{$estado->nombre}}</a>
                                            </li>
                                        @else

                                            @if($loop->last)
                                                <li role="presentation" class=""><a href="#tab{{$estado->id}}" role="tab" id="{{$estado->id}}-tab" data-toggle="tab" aria-expanded="false">{{$estado->nombre}}</a>
                                                </li>
                                            @endif
                                        @endif
                                    @endif
                                @endif

                            @endforeach--}}
                        </ul>
                        <div id="myTabContent" class="tab-content" style="margin-top: 10px;">
                            {{--@foreach($estados as $estado)
                                @if($loop->iteration==1)
                                <div role="tabpanel" class="tab-pane fade active in" id="tab{{$estado->id}}" aria-labelledby="home-tab">
                                </div>
                                @else
                                <div role="tabpanel" class="tab-pane fade" id="tab{{$estado->id}}" aria-labelledby="profile-tab">
                                </div>
                                @endif
                            @endforeach--}}
                            <div id="contenido-tab" class="table-responsive">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @include('pedidos.modals.modal-items')
    @include('pedidos.modals.modal-asignar')
    @include('pedidos.modals.modal-estados')
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            pedidos: "{{route('pedidos.estados')}}",
            cantidad: "{{route('pedidos.cantidad')}}",
            getItem: "{{route('pedidos.items')}}",
            getEstado: "{{route('pedidos.progreso')}}",
            editPedido: "{{route('pedidos.edit',['id'=>':id'])}}",
            verificacion: "{{route('verificacion.show',['id'=>':id'])}}",
            verificacionAutorizador: "{{route('autorizador.show',['id'=>':id'])}}",
            asignadorEdit: "{{route('asignaciones.edit',['id'=>':id'])}}",
            token: "{{Session::token()}}"
        };
        var variables = {
            estados: {!! json_encode($estados) !!},
            uR: {{ \Illuminate\Support\Facades\Auth::user()->rol_id }}
        };
    </script>
    {{ Html::script('/js/select2.full.js') }}
    {{ Html::script('/js/pedidos/index-p.js') }}
@endsection