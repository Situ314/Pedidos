<!-- Modal -->
<div id="modalDevolucion" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="modalDevolucionHeader" class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="modalDevolucionTitle" class="modal-title"></h4>
            </div>
            {{ Form::open( array('route' => 'devolucion.store', 'method' => 'POST','class' => 'form-horizontal') ) }}
            <input name="tipo_dev" hidden>
            <input name="pedido_id" hidden value="{{$pedido->id}}">

            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label for="motivo" class="control-label">* Motivo</label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {{Form::textarea('motivo', null, ['class' => 'form-control text-uppercase', 'required', 'rows'=>'3'])}}
                        @if ($errors->has('motivo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('motivo') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnAceptarDevolucion" class="btn btn-primary-custom"></button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            {{Form::close()}}

        </div>

    </div>
</div>