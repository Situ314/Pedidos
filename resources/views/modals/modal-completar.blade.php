<!-- Modal -->
<div id="modalEntregarPedido" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Entregar Pedido</h4>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                {{ Form::open( array('route' => ['responsable.completar', ':id'], 'method' => 'GET','class' => 'form-horizontal', 'id'=>'formCompletarPedidoEntregado') ) }}
            @else
                {{ Form::open( array('route' => ['responsable.completarTic', ':id'], 'method' => 'GET','class' => 'form-horizontal', 'id'=>'formCompletarPedidoEntregadoTic') ) }}
            @endif
            <div class="modal-body">
                <p><b>Al darle click en <i>Completar Pedido</i> el pedido autmaticaménte pasara a <i>Finalizado</i> y los items que no tuvieron una salida sera eliminados</b></p>

                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label for="motivo_entrega" class="control-label">* Motivo</label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        {{Form::textarea('motivo_entrega', null, ['class' => 'form-control text-uppercase', 'required', 'rows'=>'3'])}}
                        @if ($errors->has('motivo_entrega'))
                            <span class="help-block">
                                <strong>{{ $errors->first('motivo_entrega') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success-custom"><i class="fa fa-arrow-right"></i> Completar Pedido </button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>

            {{Form::close()}}

        </div>
    </div>
</div>