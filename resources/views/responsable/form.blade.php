<div class="form-group">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="empresa_id" class="control-label">* Empresa</label>
        {{ Form::select('empresa_id', $empresas->pluck('nombre','id'), null, ['class' => 'js-placeholder-single', 'required']) }}
        @if ($errors->has('empresa_id'))
            <span class="help-block">
                <strong>{{ $errors->first('empresa_id') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="proyecto_id" class="control-label">* Proyecto</label>
        {{Form::select('proyecto_id', array(null), null, ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('proyecto_id'))
            <span class="help-block">
                <strong>{{ $errors->first('proyecto_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="num_ot" class="control-label">Numero de OT</label>
        {{Form::number('num_ot',null, ['class'=>'form-control', 'step'=>1,'min'=>1])}}
        @if ($errors->has('num_ot'))
            <span class="help-block">
                <strong>{{ $errors->first('num_ot') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="area" class="control-label">* Area</label>
        {{Form::text('area',null, ['class'=>'form-control text-uppercase', 'required'])}}
        @if ($errors->has('area'))
            <span class="help-block">
                <strong>{{ $errors->first('area') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="responsable_entrega_id" class="control-label">* Responsable de Entrega</label>
        @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 11)
            <select name="responsable_entrega_id" class="js-placeholder-single" required>
                @foreach($responsablestic as $user)
                    @if(count($user->empleado) != 0)
                        <option value="{{$user->id}}">{{$user->empleado->nombre_completo}} ({{$user->username}})</option>
                    @else
                        <option value="{{$user->id}}">{{$user->username}}</option>
                    @endif
                @endforeach
            </select>
        @else
            <select name="responsable_entrega_id" class="js-placeholder-single" required>
                <optgroup label="Responsables de Entrega">
                    @foreach($responsablessentrega as $user)
                        @if(count($user->empleado) != 0)
                            <option value="{{$user->id}}">{{$user->empleado->nombre_completo}} ({{$user->username}})</option>
                        @else
                            <option value="{{$user->id}}">{{$user->username}}</option>
                        @endif
                    @endforeach
                </optgroup>
                <optgroup label="Responsables">
                    @foreach($responsables as $user)
                        @if(count($user->empleado) != 0)
                            <option value="{{$user->id}}">{{$user->empleado->nombre_completo}} ({{$user->username}})</option>
                        @else
                            <option value="{{$user->id}}">{{$user->username}}</option>
                        @endif
                    @endforeach
                </optgroup>
            </select>
        @endif
        @if ($errors->has('responsable_entrega_id'))
            <span class="help-block">
                <strong>{{ $errors->first('responsable_entrega_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="responsable_entrega_id" class="control-label">Delivery</label>
        {{Form::select('courrier_id', $empleados->pluck('nombre_completo','id'), null, ['class' => 'js-placeholder-single'])}}
        @if ($errors->has('courrier_id'))
            <span class="help-block">
                <strong>{{ $errors->first('courrier_id') }}</strong>
            </span>
        @endif
    </div>
</div>