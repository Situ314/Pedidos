<!-- Modal -->
<div id="modalConfirmacionProceso" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-warning">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="fa fa-warning"></i> Confirmar</h4>
            </div>
            {{ Form::open( array('route' => 'pedidos.proceso', 'method' => 'POST','class' => 'form-horizontal form-label-left input_mask') ) }}
            <div class="modal-body">
                <p>¿Esta seguro que desea cambiar a en proceso?</p>
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label for="motivo" class="control-label">Nota (Si desea agregar una nota)</label>
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
            </div>
            <input name="pedido_proceso_id" hidden>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-warning">Si</button>
            </div>
            {{Form::close()}}
        </div>

    </div>
</div>