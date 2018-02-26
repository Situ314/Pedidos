@extends('layouts.main')

@section('content')
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-location-arrow"></i> Pedidos Totales</span>
            <div class="count" id="div-estado-0">0</div>
            <span class="count_bottom"> Todos los pedidos</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-info"></i> Inicial</span>
            <div class="count info" id="div-estado-1">0</div>
            <span class="count_bottom"> Pedido generado</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-key"></i> Autorizados</span>
            <div class="count blue" id="div-estado-2">0</div>
            <span class="count_bottom"> Pedido autorizados</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Parcial</span>
            <div class="count red" id="div-estado-4">0</div>
            <span class="count_bottom"> Pedido entregado parcialmente</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-arrow-right"></i> Entregado</span>
            <div class="count orange" id="div-estado-5">0</div>
            <span class="count_bottom"> Pedido completado</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-check"></i> Finalizado</span>
            <div class="count green" id="div-estado-8">0</div>
            <span class="count_bottom"> Pedido finalizado</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">

                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>Pedidos <small>Actividad de pedidos</small></h3>
                    </div>
                    <div class="col-md-6">
                        <div id="dateRange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span></span> <b class="caret"></b>
                        </div>
                        {{--<input type="text" name="daterange" value="01/01/2015 1:30 PM - 01/01/2015 2:00 PM" />--}}
                    </div>
                </div>

                <div class="col-md-9 col-sm-9 col-xs-12">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 bg-white">
                    <div class="x_title">
                        <h2>Pedidos</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-6">
                        <div>
                            <p>Inicial</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-default" role="progressbar" data-transitiongoal="80" aria-valuenow="79" style="width: 80%;"></div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p>Autorizado</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-blue" role="progressbar" data-transitiongoal="60" aria-valuenow="59" style="width: 60%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-6">
                        <div>
                            <p>Parcial</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-red" role="progressbar" data-transitiongoal="40" aria-valuenow="39" style="width: 40%;"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Entregado</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-warning" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 50%;"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Finalizado</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50" aria-valuenow="49" style="width: 50%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="clearfix"></div>
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