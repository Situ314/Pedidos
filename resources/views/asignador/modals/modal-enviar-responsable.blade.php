<div id="enviarResponsableModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="titulo" class="modal-title">Enviar correo electrónico Informe Pedido: </h4>
            </div>
            <div id="bodyPedido" class="modal-body">
                <span id="responsable-modal">

                </span>

                <br>
                <br>

                <span>
                    <strong>¿Está seguro de querer enviarlo?</strong>
                </span>
                <input name="responsable" id="pedido" type="hidden" class="form-control">
                <input name="tipo" id="tipo" type="hidden" class="form-control">
            </div>
            <div class="modal-footer">
                <button id="enviar-modal" type="button" data-dismiss="modal" class="btn btn-info-custom">Enviar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>