@extends('layouts.main')

@section('content')
    <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>Pedidos Asignados ({{count($pedidos)}} pedidos)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="overflow: auto;max-height: 500px">
                @if($pedidos->count() > 0)
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th style="color: white">Código</th>
                        <th style="color: white">Empresa</th>
                        <th style="color: white">Solicitante</th>
                        <th style="color: white">Creado:</th>
                        <th style="color: white"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pedidos as $pedido)
                    @php
                        \Carbon\Carbon::setLocale('es');
                        $date = \Carbon\Carbon::parse($pedido->created_at);

                        $diff = $date->diffForHumans();
                        $diffDays = $date->diffInDays();

                        $color = 'rgba(27,126,90,0.2)';
                        $label = 'label-success';
                        if($diffDays > 7){
                            $color = 'rgba(255,252,22,0.25)';
                            $label = 'label-warning';
                        }if($diffDays > 15){
                            $color = 'rgba(231,109,0,0.11)';
                            $label = 'label-warning';
                        }if($diffDays > 30){
                            $color = 'rgba(126,0,2,0.1)';
                            $label = 'label-danger';
                        }
                    @endphp
                    <tr style="background-color: {{$color}};">
                        <td>{{$pedido->codigo}}</td>
                        <td>{{$pedido->proyecto_empresa->empresa->nombre}}</td>
                        <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                        <td>{{$pedido->created_at}}</td>
                        <td><span class="label {{$label}}">{{$diff}}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                    @else
                    <div class="alert alert-success alert-dismissible fade in" role="alert"><strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel tile">
            <div class="x_title">
                <h2>Pedidos Parciales Pendientes ({{count($pedidos_parciales)}} pedidos)</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="overflow: auto;max-height: 500px">
                @if($pedidos_parciales->count() > 0)
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                    <tr>
                        <th style="color: white">Código</th>
                        <th style="color: white">Empresa</th>
                        <th style="color: white">Solicitante</th>
                        <th style="color: white">Solicitud</th>
                        <th style="color: white">Creado</th>
                        <th style="color: white"></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pedidos_parciales as $pedido)
                        @php
                            \Carbon\Carbon::setLocale('es');
                            $date = \Carbon\Carbon::parse($pedido->created_at);

                            $diff = $date->diffForHumans();
                            $diffDays = $date->diffInDays();

                            $color = 'rgba(27,126,90,0.2)';
                            $label = 'label-success';
                            if($diffDays > 7){
                                $color = 'rgba(255,252,22,0.25)';
                                $label = 'label-warning';
                            }if($diffDays > 15){
                                $color = 'rgba(231,109,0,0.11)';
                                $label = 'label-warning';
                            }if($diffDays > 30){
                                $color = 'rgba(126,0,2,0.1)';
                                $label = 'label-danger';
                            }
                        @endphp
                        <tr style="background-color: {{$color}};">
                            <td>{{$pedido->codigo}}</td>
                            <td>{{$pedido->proyecto_empresa->empresa->nombre}}</td>
                            <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                            <td> # {{$pedido->salidas_almacen->first()->num_solicitud}}</td>
                            <td>{{$pedido->created_at}}</td>
                            <td>
                                <span class="label {{$label}}">{{$diff}}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-success alert-dismissible fade in" role="alert"><strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado</div>
                @endif
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2>Pedidos Despachados ({{count($pedidos_despachados)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    @if($pedidos_despachados->count() > 0)
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr>
                                <th style="color: white">Código</th>
                                <th style="color: white">Empresa</th>
                                <th style="color: white">Solicitante</th>
                                <th style="color: white">Solicitud</th>
                                <th style="color: white">Creado</th>
                                <th style="color: white"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pedidos_despachados as $pedido)
                                @php
                                    \Carbon\Carbon::setLocale('es');
                                    $date = \Carbon\Carbon::parse($pedido->created_at);

                                    $diff = $date->diffForHumans();
                                    $diffDays = $date->diffInDays();

                                    $color = 'rgba(27,126,90,0.2)';
                                    $label = 'label-success';
                                    if($diffDays > 7){
                                        $color = 'rgba(255,252,22,0.25)';
                                        $label = 'label-warning';
                                    }if($diffDays > 15){
                                        $color = 'rgba(231,109,0,0.11)';
                                        $label = 'label-warning';
                                    }if($diffDays > 30){
                                        $color = 'rgba(126,0,2,0.1)';
                                        $label = 'label-danger';
                                    }
                                @endphp
                                <tr style="background-color:{{$color}};">
                                    <td>{{$pedido->codigo}}</td>
                                    <td>{{$pedido->proyecto_empresa->empresa->nombre}}</td>
                                    <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                                    @if($pedido->salidas_almacen->first() != null)
                                        <td> # {{$pedido->salidas_almacen->first()->num_solicitud}}</td>
                                    @else
                                        <td> # 1</td>
                                    @endif
                                    <td>{{$pedido->created_at}}</td>
                                    <td><span class="label {{$label}}">{{$diff}}</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success alert-dismissible fade in" role="alert"><strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel tile">
                <div class="x_title">
                    <h2>Pedidos En Espera ({{count($pedidos_espera)}} pedidos)</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="overflow: auto;max-height: 500px">
                    @if($pedidos_espera->count() > 0)
                        <table class="table table-striped jambo_table bulk_action">
                            <thead>
                            <tr>
                                <th style="color: white">Código</th>
                                <th style="color: white">Empresa</th>
                                <th style="color: white">Solicitante</th>
                                <th style="color: white">Creado</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pedidos_espera as $pedido)
                                @php
                                    \Carbon\Carbon::setLocale('es');
                                    $date = \Carbon\Carbon::parse($pedido->created_at);

                                    $diff = $date->diffForHumans();
                                    $diffDays = $date->diffInDays();

                                    $color = 'rgba(27,126,90,0.2)';
                                    $label = 'label-success';
                                    if($diffDays > 7){
                                        $color = 'rgba(255,252,22,0.25)';
                                        $label = 'label-warning';
                                    }if($diffDays > 15){
                                        $color = 'rgba(231,109,0,0.11)';
                                        $label = 'label-warning';
                                    }if($diffDays > 30){
                                        $color = 'rgba(126,0,2,0.1)';
                                        $label = 'label-danger';
                                    }
                                @endphp
                                <tr style="background-color: {{$color}};">
                                    <td>{{$pedido->codigo}}</td>
                                    <td>{{$pedido->proyecto_empresa->empresa->nombre}}</td>
                                    <td>{{$pedido->solicitante_empleado->empleado->nombres}} {{$pedido->solicitante_empleado->empleado->apellido_1}} {{$pedido->solicitante_empleado->empleado->apellido_2}}</td>
                                    <td>{{$pedido->created_at}}</td>
                                    <td>
                                        <span class="label {{$label}}">{{$diff}}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success alert-dismissible fade in" role="alert"><strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/Chart.min.js') }}
    {{ Html::script('/js/dashboard.js') }}

    <script type="text/javascript">
        var rutas = {
            chartData: "{{route('dash.fecha',['inicio'=>':inicio','fin'=>':fin'])}}",

            token: "{{Session::token()}}"
        };
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            responsive: true,
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: 'Inicial',
                    data: [2, 1, 5, 7, 6, 4],
                    fill: false,
                    borderColor: [
                        'rgba(115, 135, 156, 1)',
                    ],
                    borderWidth: 2
                },{
                    label: 'Autorizado',
                    data: [12, 19, 3, 5, 2, 3],
                    fill: false,
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                    ],
                    borderWidth: 2
                },{
                    label: 'Parcial',
                    data: [9, 2, 3, 13, 2, 1],
                    fill: false,
                    borderColor: [
                        'rgba(231,76,60,1)',
                    ],
                    borderWidth: 2
                },{
                    label: 'Entregado',
                    data: [14, 6, 9, 1, 11, 17],
                    fill: false,
                    borderColor: [
                        'rgba(240,173,78,1)',
                    ],
                    borderWidth: 2
                },{
                    label: 'Finalizado',
                    data: [1, 7, 3, 14, 22, 1],
                    fill: false,
                    borderColor: [
                        'rgba(26,187,156,1)',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                legend: {
                    labels: {

                        fontSize: 12
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontSize: 10,
                            stepSize: 2,
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            stepSize: 1,
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

    </script>
@endsection