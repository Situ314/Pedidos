<div class="form-group">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label"><i class="fa fa-institution"></i> Empresa Salida</label>
        <p id="txtEmpresa">{{$salida->proyecto->empresa->nombre}}</p>
        <input name="empresa_id" hidden value="{{$salida->proyecto->empresa_id}}">
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label"><i class="fa fa-institution"></i> Proyecto Salida</label>
        <p id="txtProyecto">{{$salida->proyecto->nombre}}</p>
        <input name="proyecto_id" hidden value="{{$salida->proyecto->id}}">
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label"><i class="fa fa-list-ol"></i> Numero OT</label>
        @if($salida->num_ot != null)
            <p>{{$salida->num_ot}}</p>
            <input name="num_ot" hidden value="{{$salida->num_ot}}">
        @else
            <p>SIN NUMERO</p>
            <input name="num_ot" hidden value="">
        @endif
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label"><i class="fa fa-square-o"></i> Área</label>
        <p>{{$salida->area}}</p>
        <input name="area" hidden value="{{$salida->area}}">
    </div>
</div>

<div class="form-group">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="responsable_entrega_id" class="control-label">Responsable de Entrega *</label>
        {{--        {{Form::select('responsable_entrega_id', $responsables->pluck('empleado_usuario','id'), null, ['class' => 'js-placeholder-single', 'required'])}}--}}
        <select name="responsable_entrega_id" class="js-placeholder-single" required>
            @foreach($responsables as $user)
                @if(count($user->empleado) != 0)
                    <option value="{{$user->id}}">{{$user->empleado->nombre_completo}} ({{$user->username}})</option>
                @else
                    <option value="{{$user->id}}">{{$user->username}}</option>
                @endif
            @endforeach
        </select>
        @if ($errors->has('responsable_entrega_id'))
            <span class="help-block">
                <strong>{{ $errors->first('responsable_entrega_id') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <label for="responsable_entrega_id" class="control-label">Courrier</label>
        {{Form::select('courrier_id', $empleados->pluck('nombre_completo','id'), null, ['class' => 'js-placeholder-single'])}}
        @if ($errors->has('courrier_id'))
            <span class="help-block">
                <strong>{{ $errors->first('courrier_id') }}</strong>
            </span>
        @endif
    </div>
</div>