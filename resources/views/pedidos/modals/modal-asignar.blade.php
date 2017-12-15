<!-- Modal -->
<div id="modalAsignacion" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Asignación</h4>
            </div>
            {{ Form::open( array('route' => 'asignaciones.store', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}
            <div class="modal-body">
                <input name="pedido_responsable_id" class="hidden" />
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="responsable_id">Responsable *</label>
                            <select name="responsable_id" class="js-placeholder-single" required>
                                @foreach($usuarios as $usuario)
                                    @if($usuario->rol_id == 4)
                                        <option value="{{$usuario->id}}">{{$usuario->empleado->nombres}} ({{$usuario->username}})</option>
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
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"> Cerrar</i></button>
                <button type="submit" class="btn btn-info-custom"><i class="fa fa-mail-forward"> Asignar</i></button>
            </div>
            {{Form::close()}}

        </div>

    </div>
</div>