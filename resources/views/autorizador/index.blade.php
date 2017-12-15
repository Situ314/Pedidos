@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Mis usuarios <small>Listado de los usuarios los cuales soy responsable</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombres</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($responsables as $responsable)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$responsable->solicitante->empleado->nombres}}</td>
                            <td>{{$responsable->solicitante->username}}</td>
                            <td>{{$responsable->solicitante->email}}</td>
                            <td>
                                @if($responsable->solicitante->rol_id == 5)
                                    <span class="label-danger">Autorizador</span>
                                @else
                                    <span class="label-success">Usuario</span>
                                @endif
                            </td>
                            <td>
                                @if(\Illuminate\Support\Facades\Auth::user()->id == $responsable->solicitante->id)
                                    <a disabled="" class="btn btn-sm btn-warning" title="No puede realizar acciones sobre si mismo"><i class="glyphicon glyphicon-minus"></i></a>
                                @else
                                    @if($responsable->solicitante->rol_id == 5)
                                        <a href="{{route('autorizador.cambiar',[$responsable->solicitante->id,2])}}" class="btn btn-sm btn-success-custom" title="Convertir en usuario"><i class="glyphicon glyphicon-arrow-down"></i></a>
                                    @else
                                        <a href="{{route('autorizador.cambiar',[$responsable->solicitante->id,1])}}" class="btn btn-sm btn-danger-custom" title="Convertir en autorizador" ><i class="glyphicon glyphicon-arrow-up"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/autoriz/index-a.js') }}
@endsection