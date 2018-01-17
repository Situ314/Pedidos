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
                    @php $aux=1;@endphp
                    @foreach($responsables as $responsable)
                        @if(\Illuminate\Support\Facades\Auth::id()!=$responsable->solicitante->id)
                        <tr>
                            <th scope="row">@php echo $aux; $aux++; @endphp</th>
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
                                @if($responsable->solicitante->rol_id == 5)
                                    <a href="{{route('autorizador.cambiar',[$responsable->solicitante->id,2])}}" class="btn btn-sm btn-success-custom" title="Convertir en usuario"><i class="glyphicon glyphicon-arrow-down"></i></a>
                                @else
                                    <a href="{{route('autorizador.cambiar',[$responsable->solicitante->id,1])}}" class="btn btn-sm btn-danger-custom" title="Convertir en autorizador" ><i class="glyphicon glyphicon-arrow-up"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endif
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