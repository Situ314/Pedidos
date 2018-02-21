@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="x_panel">
                <div class="x_content">
                    <div class="row">
                    @foreach($users as $user)
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 profile_details">
                            <div class="well profile_view">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 fixed_height_260">
                                    <h4 class="control-label">
                                        <i>
                                            @if(count($user->solicitante->empleado) > 0)
                                                {{$user->solicitante->empleado->laboral_empleado->cargo->nombre}}
                                            @else
                                                SIN CARGO
                                            @endif
                                        </i>
                                    </h4>
                                    <div class="left col-xs-7">
                                        <h2 class="control-label">
                                            @if(count($user->solicitante->empleado) > 0)
                                                {{$user->solicitante->empleado->nombre_completo}}
                                            @else
                                                {{$user->solicitante->username}}
                                            @endif
                                        </h2>
                                        <p>
                                            <strong>Lugar: </strong>
                                            @if(count($user->solicitante->empleado) > 0)
                                                {{$user->solicitante->empleado->proyecto->empresa->nombre}} / {{$user->solicitante->empleado->proyecto->nombre}}
                                            @endif
                                        </p>
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-envelope"></i> Correo:
                                                @if(count($user->solicitante->empleado) > 0)
                                                    {{$user->solicitante->empleado->laboral_empleado->email_corporativo}}
                                                @endif
                                            </li>
                                            <li><i class="fa fa-phone"></i> Corto:
                                                @if(count($user->solicitante->empleado) > 0)
                                                    {{$user->solicitante->empleado->laboral_empleado->numero_corto_corporativo}}
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="{{asset('images/user.png')}}" alt="" class="img-circle img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-12 bottom text-center">
                                    @if($user->solicitante->rol_id != 5)
                                        <button type="button" title="Modificar equipo" class="btn btn-info-custom btn-xs" onclick="equipo({{$user->id}});">
                                            <i class="fa fa-edit"></i> Equipo
                                        </button>
                                        <button type="button" title="Convertir en autorizador" class="btn btn-success-custom btn-xs" onclick="autorizador({{$user->id}});">
                                            <i class="fa fa-arrow-up"></i> Autorizador
                                        </button>
                                    @else
                                        <button type="button" title="Convertir en usuario" class="btn btn-danger-custom btn-xs" onclick="usuario({{$user->id}});">
                                            <i class="fa fa-arrow-down"></i> Usuario
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('footerScripts')
    @parent
    {{ Html::script('/js/admin/aut.js') }}

@endsection