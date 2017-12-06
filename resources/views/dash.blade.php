@extends('layouts.main')

@section('content')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon" style=""><i class="fa fa-file"></i></div>
                <div class="count">0</div>
                <h3>Pedidos</h3>
                <p>Pedidos totales</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-check"></i></div>
                <div class="count">0</div>
                <h3>Recibidos</h3>
                <p>Correspondencia recibida</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-refresh"></i></div>
                <div class="count">0</div>
                <h3>En curso</h3>
                <p>Correspondencia en curso</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-stop-circle-o"></i></div>
                <div class="count">0</div>
                <h3>Cerrados</h3>
                <p>Correspondencia cerrada</p>
            </div>
        </div>
    </div>

@endsection
