<!-- Modal -->
<div id="modalUserPassword" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-warning
">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user"></i> Actualizar Contraseña de Usuario</h4>
            </div>
            {{ Form::open( array('route' => ['admin-usuario.update.password','id'=>':id'], 'method' => 'PUT','class' => 'form-horizontal input_mask', 'id'=>'formUpdatePassword', 'data-toggle'=>'validator') ) }}
            <div class="modal-body">

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

                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="password_repeat" class="control-label">Repita la Contraseña *</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{Form::password('password_repeat', ['class' => 'form-control', 'required'])}}
                        @if ($errors->has('password_repeat'))
                            <span class="help-block">
                <strong>{{ $errors->first('password_repeat') }}</strong>
                </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="btn btn-info-custom"><i class="fa fa-check"></i> Actualizar</button>
            </div>
            {{Form::close()}}

        </div>

    </div>
</div>