{{--<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="empresa_id" class="control-label">Solicitante *</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{ Form::select('solicitante_id', array(null), null, ['class' => 'js-placeholder-single', 'required','id'=>'solicitante_id']) }}
        @if ($errors->has('solicitante_id'))
            <span class="help-block">
                <strong>{{ $errors->first('solicitante_id') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="empresa_id" class="control-label">Empresa *</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{ Form::select('empresa_id', array(null), null, ['class' => 'js-placeholder-single', 'required']) }}
        @if ($errors->has('empresa_id'))
            <span class="help-block">
                <strong>{{ $errors->first('empresa_id') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="proyecto_id" class="control-label">Proyecto *</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{Form::select('proyecto_id', array(null), null, ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('proyecto_id'))
            <span class="help-block">
                <strong>{{ $errors->first('proyecto_id') }}</strong>
            </span>
        @endif
    </div>
</div>--}}
@if(count(\Illuminate\Support\Facades\Auth::user()->empleado)==0)
    <div class="alert alert-warning">
        <strong><i class="fa fa-user"></i> Alerta!</strong> Usted no cuenta con un empleado relacionado a su usuario, comuniquese con sistemas
    </div>
@else
    @if(count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud) == 0)
        <div class="alert alert-warning">
            <strong><i class="fa fa-user"></i> Alerta!</strong> No cuenta con usuario en solicitudes, comuniquese con sistemas
        </div>
    @else
        @if( count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos)==0 )
            <div class="alert alert-warning">
                <strong><i class="fa fa-institution"></i> Alerta!</strong> No cuenta con proyectos en el sistema de solicitudes, comuniquese con sistemas
            </div>
        @endif
    @endif
@endif

<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label">Motivo *</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{Form::textarea('motivo',null, ['class' => 'form-control text-uppercase', 'required','rows'=>'2'])}}
        @if ($errors->has('motivo'))
            <span class="help-block">
                <strong>{{ $errors->first('motivo') }}</strong>
            </span>
        @endif
    </div>
</div>

@if(count(\Illuminate\Support\Facades\Auth::user()->empleado) != 0)
    @if(count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud) != 0)
        @if( count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos)!=0 )
            @if(count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos)>1)
            <div class="form-group">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="proyecto_id" class="control-label">Proyecto *</label>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    {{Form::select('proyecto_id', \Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos->pluck('proyecto_empresa','id'), null, ['class' => 'js-placeholder-single', 'required'])}}
                    @if ($errors->has('proyecto_id'))
                        <span class="help-block">
                    <strong>{{ $errors->first('proyecto_id') }}</strong>
                </span>
                    @endif
                </div>
            </div>
            @else
                <input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos[0]->id}}">
            @endif
        @endif
    @endif
@endif

{{--@if(count(\Illuminate\Support\Facades\Auth::user()->proyectos)==1)
    <input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->proyectos[0]->id}}">
@else
    <div class="form-group">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="proyecto_id" class="control-label">Proyecto *</label>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{Form::select('proyecto_id', \Illuminate\Support\Facades\Auth::user()->proyectos, null, ['class' => 'js-placeholder-single', 'required'])}}
            @if ($errors->has('proyecto_id'))
                <span class="help-block">
                <strong>{{ $errors->first('proyecto_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
@endif--}}
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="tipo_cat_id" class="control-label">Tipo Pedido *</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{Form::select('tipo_cat_id', $tipos->pluck('nombre','id'), null, ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('tipo_cat_id'))
            <span class="help-block">
                <strong>{{ $errors->first('tipo_cat_id') }}</strong>
            </span>
        @endif
    </div>
</div>

{{--<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name">
    <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <input type="text" class="form-control has-feedback-right" id="inputSuccess3" placeholder="Last Name">
    <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
    <input type="text" class="form-control" id="inputSuccess5" placeholder="Phone">
    <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
</div>--}}

