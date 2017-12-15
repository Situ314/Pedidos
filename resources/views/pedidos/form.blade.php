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

@if(count(\Illuminate\Support\Facades\Auth::user()->proyectos)==1)
    <input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->proyectos[0]->id}}">
@else
    <div class="form-group">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label for="proyecto_id" class="control-label">Proyecto *</label>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            {{Form::select('proyecto_id', \Illuminate\Support\Facades\Auth::user()->proyectos->pluck('nombre','id'), null, ['class' => 'js-placeholder-single', 'required'])}}
            @if ($errors->has('proyecto_id'))
                <span class="help-block">
                <strong>{{ $errors->first('proyecto_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
@endif
<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="tipo_cat_id" class="control-label">Tipo Categroia*</label>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
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

