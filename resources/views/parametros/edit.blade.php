@extends('layouts.main')

@section('headerScripts')
    {{ Html::style('/css/select2.min.css') }}
@endsection

@section('content')
    <div>
        <div class="page-title">
            <div class="title_left">
                <h3>Lista de Parámetros</h3>
            </div>

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="x_panel">
        <div class="row">
            <div class="col-md-4">
                {{--<div class="x_content" style="-webkit-flex: 1 1 auto; overflow-y: auto; height: 500px;">--}}
                <div class="x_content">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #2a3f54; border-bottom: solid 4px #e7b201">
                            <h4 style="color: white"><i class="fa fa-btn fa-arrow-down"></i> Parámetros
                                <span>Retraso Mínimo</span>
                            </h4>
                        </div>

                        <div class="panel-body">

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4">
                {{--<div class="x_content" style="-webkit-flex: 1 1 auto; overflow-y: auto; height: 500px;">--}}
                <div class="x_content">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #2a3f54; border-bottom: solid 4px #e45d00">
                            <h4 style="color: white"><i class="fa fa-btn fa-arrow-right"></i> Parámetros
                                <span>Retraso Moderado</span>
                            </h4>
                        </div>

                        <div class="panel-body">

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-md-4">
                {{--<div class="x_content" style="-webkit-flex: 1 1 auto; overflow-y: auto; height: 500px;">--}}
                <div class="x_content">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="background-color: #2a3f54; border-bottom: solid 4px #6a0d02">
                            <h4 style="color: white"><i class="fa fa-btn fa-arrow-up"></i> Parámetros
                                <span>Retraso Alto</span>
                            </h4>
                        </div>

                        <div class="panel-body">

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection