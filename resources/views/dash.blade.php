@extends('layouts.main')

@section('content')
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-location-arrow"></i> Pedidos Totales</span>
            <div class="count">0</div>
            <span class="count_bottom"> Todos los pedidos</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Realizado</span>
            <div class="count info">2</div>
            <span class="count_bottom"> Pedido generado</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Autorizados</span>
            <div class="count info">9</div>
            <span class="count_bottom"> Pedido autorizados</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Proceso</span>
            <div class="count red">0</div>
            <span class="count_bottom"> Pedido verificandose</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Comprobado</span>
            <div class="count orange">4</div>
            <span class="count_bottom"> Pedido registrado y realizado</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Entregado</span>
            <div class="count green">10</div>
            <span class="count_bottom"> Pedido entregado</span>
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
                        <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                            <span>November 14, 2017 - December 13, 2017</span> <b class="caret"></b>
                        </div>
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
                            <p>Realizados</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-primary" role="progressbar" data-transitiongoal="80" aria-valuenow="79" style="width: 80%;"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Proceso</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-red" role="progressbar" data-transitiongoal="60" aria-valuenow="59" style="width: 60%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-6">
                        <div>
                            <p>Comprobado</p>
                            <div class="">
                                <div class="progress progress_sm" style="width: 76%;">
                                    <div class="progress-bar bg-orange" role="progressbar" data-transitiongoal="40" aria-valuenow="39" style="width: 40%;"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p>Entregado</p>
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
    <script type="text/javascript">
        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            responsive: true,
            data: {
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                datasets: [{
                    label: 'Realizados',
                    data: [2, 1, 5, 7, 6, 4],
                    backgroundColor: [
                        'rgba(43, 64, 84, 0.5)',
                    ],
                    borderColor: [
                        'rgba(43, 64, 84, 0.5)',
                    ],
                    borderWidth: 1
                },{
                    label: 'Entregado',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(26, 187, 156, 0.3)',
                    ],
                    borderColor: [
                        'rgba(26, 187, 156, 0.3)',
                    ],
                    borderWidth: 1
                },{
                    label: 'Proceso',
                    data: [9, 2, 3, 13, 2, 1],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    </script>
@endsection