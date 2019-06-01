@extends('layouts.app')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 col-md-offset-2">--}}
            {{--<div class="panel panel-default login-panel">--}}
                {{--<div class="panel-heading">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 panel-heading-left-logo">--}}
                            {{--<img src="http://solicitudes.pragmainvest.com.bo/empresas/tepco_srl/tepco_srl.jpg"/>--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">--}}
                            {{--<label class="panel-heading-titulo">--}}
                                {{--Bienvenido al Sistema <br>de Pedidos--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">--}}
                            {{--<img src="{{asset('images/avatar.png')}}">--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 form-login-padding">--}}
                            {{--<form role="form" method="POST" action="{{ url('/login') }}">--}}
                                {{--{{ csrf_field() }}--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                                        {{--<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">--}}

                                            {{--<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Usuario">--}}
                                            {{--@if ($errors->has('username'))--}}
                                                {{--<span class="help-block">--}}
                                                    {{--<strong>{{ $errors->first('username') }}</strong>--}}
                                                {{--</span>--}}
                                            {{--@endif--}}

                                        {{--</div>--}}

                                    {{--</div>--}}
                                    {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                                        {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                                            {{--<input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">--}}

                                            {{--@if ($errors->has('password'))--}}
                                                {{--<span class="help-block">--}}
                                                    {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                                {{--</span>--}}
                                            {{--@endif--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group pull-left">--}}
                                    {{--<div class="checkbox">--}}
                                        {{--<label>--}}
                                            {{--<input type="checkbox" name="remember"> Recuerdame--}}
                                        {{--</label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<button type="submit" class="btn btn-primary-custom btn-block">--}}
                                        {{--Iniciar Sesión--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</form>--}}

                        {{--</div>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="limiter">
    <div class="container-login100" style="background-image: url({{asset('images/back-3.jpg')}}); background-repeat: no-repeat;">
        <div class="wrap-login100">
            <form class="login100-form validate-form" role="form" method="POST" action="{{ url('/login') }}">
					<span class="login100-form-title p-b-26">
						Bienvenido
					</span>
                <span class="login100-form-title p-b-48">
						<img width="184px" height="80px" src="{{ asset('images/tepco_srl.png') }}">
					</span>

                    {{ csrf_field() }}

                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" name="username" id="username" required autofocus>
                    <span class="focus-input100" data-placeholder="Usuario"></span>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="wrap-input100 validate-input">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" id="password" type="password" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    <span class="focus-input100" data-placeholder="Contraseña"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" class="login100-form-btn">
                            Iniciar Sesión
                        </button>
                    </div>
                </div>
                </form>
                <div class="text-center p-t-115">
						<span class="txt1">
							¿No tiene una cuenta?
						</span>
<br>
                    <a class="txt2" href="#">
                        Comuníquese con el Número de Soporte (1610)
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $( document ).ready(function() {
            console.log( "ready!" );

            $(".validate-form").parsley({
                successClass: "has-success",
                errorClass: "has-error",
                classHandler: function (el) {
                    return el.$element.closest(".form-group");
                },
                errorsContainer: function (el) {
                    return el.$element.closest(".form-group");
                },
            });

            $('#btnBuscar').on('click',function (e) {
               e.preventDefault();
               var action = $('#formBuscar').attr('action').replace(':buscar',$('input[name=codigo]').val());
                $('#formBuscar').attr('action',action).submit();
            });
        });
    </script>
@endsection
