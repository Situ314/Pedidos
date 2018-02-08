<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label">Nota para responsable (Si es necesaria)</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {{Form::textarea('motivo',null, ['class' => 'form-control text-uppercase','rows'=>'2'])}}
        @if ($errors->has('motivo'))
            <span class="help-block">
                <strong>{{ $errors->first('motivo') }}</strong>
            </span>
        @endif
    </div>
</div>

@if(count($pedido->solicitante->proyectos)==1)
    <input name="proyecto_id" hidden value="{{$pedido->proyecto_id}}">
@else
    <div class="form-group">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label for="proyecto_id" class="control-label">* Proyecto</label>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {{Form::select('proyecto_id', $pedido->solicitante->empleado->usuario_solicitud->proyectos->pluck('proyecto_empresa','id'), $pedido->proyecto_id, ['class' => 'js-placeholder-single', 'required'])}}
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
        <label for="tipo_cat_id" class="control-label">Tipo Categroia*</label>
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

<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="tipo_cat_id" class="control-label">Responsable*</label>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
{{--        {{Form::select('responsable_id', $users->pluck('empleado_usuario','id'), array(null), ['class' => 'js-placeholder-single', 'required'])}}--}}
        <select name="responsable_id" class="js-placeholder-single" required>
            @foreach($users as $user)
                @if(count($user->empleado) != 0)
                    <option value="{{$user->id}}">{{$user->empleado->nombre_completo}} ({{$user->username}})</option>
                @else
                    <option value="{{$user->id}}">{{$user->username}}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has('responsable_id'))
            <span class="help-block">
                <strong>{{ $errors->first('responsable_id') }}</strong>
            </span>
        @endif
    </div>
</div>