@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cambio de contraseña<small>formulario de cambio</small></h2>
                    <div class="clearfix"></div>
                </div>
                {{Form::open( array('route' => array('cambiar-pass.update',$user->id),'method' => 'PUT', 'class'=>'form-horizontal form-label-left') )}}

                <div class="x_content">
                    @include('auth.passwords.form-change-pass')

                    <div class="ln_solid"></div>

                    <div class="row text-center" style="margin-top: 10px;">
                        <a href="{{URL::previous()}}" class="btn btn-info-custom" type="submit"><i class="fa fa-arrow-left"> Volver</i></a>
                        <button class="btn btn-success-custom" type="submit"><i class="fa fa-save"> Guardar</i></button>
                    </div>
                </div>

                {{Form::close()}}

            </div>
        </div>
    </div>
@endsection