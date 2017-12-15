@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
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
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            @php
                                switch (\Illuminate\Support\Facades\Auth::user()->rol_id){
                                    case 1:
                                        foreach ($estados as $estado){
                                            if($estado->id == 1){
                                            echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
                                            }else{
                                            echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
                                            }
                                        }
                                        break;
                                    case 2:
                                        break;
                                    case 3:
                                        break;
                                    case 4:
                                        break;
                                    case 5:
                                        foreach ($estados as $estado){
                                            if($estado->id == 1){
                                            echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
                                            }elseif($estado->id < 3 || $estado->id == 5){
                                            echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
                                            }
                                        }
                                        break;
                                    case 6:
                                        foreach ($estados as $estado){
                                            if($estado->id == 1){
                                            echo '<li role="presentation" class="active"><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
                                            }elseif($estado->id == 5){
                                            echo '<li role="presentation" class=""><a href="#tab'.$estado->id.'" id="'.$estado->id.'-tab" role="tab" data-toggle="tab" aria-expanded="true">'.$estado->nombre.'</a></li>';
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
                        <div id="myTabContent" class="tab-content">
                            {{--@foreach($estados as $estado)
                                @if($loop->iteration==1)
                                <div role="tabpanel" class="tab-pane fade active in" id="tab{{$estado->id}}" aria-labelledby="home-tab">
                                </div>
                                @else
                                <div role="tabpanel" class="tab-pane fade" id="tab{{$estado->id}}" aria-labelledby="profile-tab">
                                </div>
                                @endif
                            @endforeach--}}
                            <div id="contenido-tab">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @include('pedidos.modals.modal-ver')
    @include('pedidos.modals.modal-asignar')
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            pedidos: "{{route('pedidos.estados')}}",
            cantidad: "{{route('pedidos.cantidad')}}",
            getPedido: "{{route('pedidos.items')}}",
            verificacion: "{{route('verificacion.show',['id'=>':id'])}}",
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