@if(count(\Illuminate\Support\Facades\Auth::user()->empleado)==0)
    <div class="alert alert-warning">
        <strong><i class="fa fa-user"></i> Alerta!</strong> Usted no cuenta con un empleado relacionado a su usuario, comuniquese con sistemas
    </div>
@endif

{{-- SI TIENE EMPLEADO --}}
@if(count(\Illuminate\Support\Facades\Auth::user()->empleado) != 0)
    {{-- SI TIENE USUARIO EN SOLICITUDES --}}
    @if(count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud) != 0)
        {{-- SI PROYECTOS RELACIONADOS CON EL USUARIO --}}
        @if( count(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos)!=0 )

            @php $bandera = true; @endphp
            @php $array_empresas = []; @endphp
            <div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="empresa_id" class="control-label">* Empresa</label>
                        <select name="empresa_id" required class="js-placeholder-single">
                            @foreach(\Illuminate\Support\Facades\Auth::user()->empleado->usuario_solicitud->proyectos as $proyecto)
                                @if($proyecto->empresa_id == \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa_id)
                                    @php $bandera = false; @endphp
                                @endif

                                @if( !in_array($proyecto->empresa_id,$array_empresas))

                                    <option value="{{ $proyecto->empresa_id }}">{{ $proyecto->empresa->nombre }}</option>
                                    {{ array_push($array_empresas, $proyecto->empresa_id) }}
                                @endif

                            @endforeach

                            {{-- SI HUBO UNA EMPRESA IGUAL AL PROYECTO --}}
                            @if($bandera)
                                @if(!in_array(\Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa_id,$array_empresas))
                                    <option value="{{\Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa_id}}">{{\Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa->nombre}}</option>
                                @endif
                            @endif
                        </select>
                        @if ($errors->has('empresa_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('empresa_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="proyecto_id" class="control-label">* Proyecto</label>
                        {{Form::select('proyecto_id', array(null), null, ['class' => 'js-placeholder-single', 'required', 'disabled'])}}
                        @if ($errors->has('proyecto_id'))
                            <span class="help-block">
                            <strong>{{ $errors->first('proyecto_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="empresa_id" class="control-label"><i class="fa fa-bank"></i> Empresa: </label>
                    <p>{{ \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa->nombre }}</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label for="proyecto_id" class="control-label"><i class="fa fa-bank"></i> Proyecto: </label>
                    <p>{{ \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->nombre }}</p>
                </div>
            </div>
            <input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->empleado->sol_proyecto_id}}">
        @endif
    @else
        <div class="form-group">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="empresa_id" class="control-label"><i class="fa fa-bank"></i> Empresa: </label>
                <p>{{ \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->empresa->nombre }}</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="proyecto_id" class="control-label"><i class="fa fa-bank"></i> Proyecto: </label>
                <p>{{ \Illuminate\Support\Facades\Auth::user()->empleado->proyecto->nombre }}</p>
            </div>
        </div>
        <input name="proyecto_id" hidden value="{{\Illuminate\Support\Facades\Auth::user()->empleado->sol_proyecto_id}}">
    @endif

@endif

<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border-style: solid; background-color: #d2dfeb; border-color: #2a3f54; font-size: 14px;">
        <p style="color: red;"><b>NOTA: En el campo <i>(* Motivo de Pedido)</i> debe escribir la empresa y proyecto por el cual se realizara el requerimiento</b></p>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="motivo" class="control-label">* Motivo de Pedido</label>
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

<div class="form-group">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label for="tipo_cat_id" class="control-label">* Tipo de Pedido</label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
        {{Form::select('tipo_cat_id', $tipos->pluck('nombre','id'), null, ['class' => 'js-placeholder-single', 'required'])}}
        @if ($errors->has('tipo_cat_id'))
            <span class="help-block">
                <strong>{{ $errors->first('tipo_cat_id') }}</strong>
            </span>
        @endif
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
        <button type="button" class="btn btn-primary-custom" data-toggle="modal" data-target="#modalBuscarItem"><i class="fa fa-search"></i> Buscar Item</button>
    </div>
</div>
