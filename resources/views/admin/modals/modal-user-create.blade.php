<!-- Modal -->
<div id="modalUserCreate" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Crear Usuario</h4>
            </div>
            {{ Form::open( array('route' => 'admin-usuarios.store', 'method' => 'POST','class' => 'form-horizontal input_mask') ) }}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="empleado_id" class="control-label">Empleado <label id="txtEmpleadoUpdate" class="label"></label></label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{Form::select('empleado_id', $empleados->pluck('nombre_completo','id'), null, ['class' => 'js-placeholder-single'])}}
                        @if ($errors->has('empleado_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('empleado_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="rol_id" class="control-label">Rol *</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{Form::select('rol_id', $roles->pluck('nombre','id'), null, ['class' => 'js-placeholder-single', 'required'])}}
                        @if ($errors->has('rol_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('rol_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group divAutorizador">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="autorizador_id" class="control-label">Autorizador *</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{--{{Form::select('autorizador_id', $autorizadores, null, ['class' => 'js-placeholder-single'])}}--}}
                        <select name="autorizador_id" class="js-placeholder-single" required="true">
                            @foreach($autorizadores as $autorizador)
                                @if(count($autorizador->empleado)!=0)
                                    <option value="{{$autorizador->id}}">{{$autorizador->empleado->nombre_completo}} ({{$autorizador->username}})</option>
                                @else
                                    <option value="{{$autorizador->id}}">{{$autorizador->username}}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('autorizador_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('autorizador_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="username" class="control-label">Usuario *</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{Form::text('username',null, ['class' => 'form-control', 'required','rows'=>'2'])}}
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="password" class="control-label">Contraseña *</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{Form::password('password', ['class' => 'form-control', 'required'])}}
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="btn btn-success-custom"><i class="fa fa-plus"></i> Crear</button>
            </div>
            {{Form::close()}}

        </div>

    </div>
</div>