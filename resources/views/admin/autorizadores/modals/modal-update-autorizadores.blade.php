<!-- Modal -->
<div id="modalUpdateAutorizador" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-user-plus"></i> Equipo</h4>
            </div>
            {{ Form::open( array('route' => ['update.autorizadores','id'=>':id'], 'method' => 'PUT','class' => 'form-horizontal input_mask', 'id'=>'formUpdateAutorizador') ) }}
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="autorizador_id" class="control-label">* Autorizadores</label>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{--{{Form::select('autorizador_id', $autorizadores->pluck('username','id'), null, ['class' => 'js-placeholder-single', 'required'])}}--}}
                        <select name="autorizador_id[]" class="js-placeholder-single" multiple required>
                            @foreach($autorizadores as $autorizador)
                                @if(count($autorizador->empleado) > 0)
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                <button type="submit" class="btn btn-info-custom"><i class="fa fa-save"></i> Guardar</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>