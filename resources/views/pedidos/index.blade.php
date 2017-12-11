@extends('layouts.main')

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
                            @foreach($estados as $estado)
                                @if($loop->iteration==1)
                                <li role="presentation" class="active"><a href="#tab{{$estado->id}}" id="{{$estado->id}}-tab" role="tab" data-toggle="tab" aria-expanded="true">{{$estado->nombre}}</a>
                                </li>
                                @else
                                <li role="presentation" class=""><a href="#tab{{$estado->id}}" role="tab" id="{{$estado->id}}-tab" data-toggle="tab" aria-expanded="false">{{$estado->nombre}}</a>
                                </li>
                                @endif
                            @endforeach

                        </ul>
                        <div id="myTabContent" class="tab-content">
                            @foreach($estados as $estado)
                                @if($loop->iteration==1)
                                <div role="tabpanel" class="tab-pane fade active in" id="tab{{$estado->id}}" aria-labelledby="home-tab">
                                </div>
                                @else
                                <div role="tabpanel" class="tab-pane fade" id="tab{{$estado->id}}" aria-labelledby="profile-tab">
                                </div>
                                @endif
                            @endforeach
                            <div id="contenido-tab">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScripts')
    @parent
    <script type="text/javascript">
        var rutas = {
            pedidos: "{{route('pedidos.estados')}}",
            cantidad: "{{route('pedidos.cantidad')}}",
            token: "{{Session::token()}}"
        };
        var variables = {
            estados: {!! json_encode($estados) !!}
        };
    </script>

    {{ Html::script('/js/pedidos/index-p.js') }}
@endsection