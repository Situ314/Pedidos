<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label">Motivo de Edición *</label>
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

@if(count(\Illuminate\Support\Facades\Auth::user()->proyectos)==1)
<input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->proyectos[0]->id}}">
@else
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="proyecto_id" class="control-label">Proyecto *</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{Form::select('proyecto_id', \Illuminate\Support\Facades\Auth::user()->proyectos->pluck('proyecto_empresa','id'), $pedido->proyecto_id, ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('proyecto_id'))
        <span class="help-block">
                <strong>{{ $errors->first('proyecto_id') }}</strong>
            </span>
        @endif
    </div>
</div>
@endif
<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="tipo_cat_id" class="control-label">Tipo Pedido *</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{Form::select('tipo_cat_id', $tipos->pluck('nombre','id'), array(null), ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('tipo_cat_id'))
        <span class="help-block">
                <strong>{{ $errors->first('tipo_cat_id') }}</strong>
            </span>
        @endif
    </div>
</div>