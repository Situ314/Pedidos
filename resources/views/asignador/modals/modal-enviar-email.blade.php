<div id="enviarEmailModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-info">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enviar correo electrónico</h4>
                </div>
                <div id="bodyPedido" class="modal-body">
                    {!! Form::open(['route' => 'correo.responsable.informe', 'method' => 'get']) !!}
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Para (email): <span class="required">*</span>
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input name="email" id="email" type="email" class="form-control" placeholder="Ingrese la dirección de correo electrónico">
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Nombre: <span class="required">*</span>
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <input name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre de la persona a la cual le enviará el correo">
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Mensaje <span class="required">*</span>
                        </label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                            <textarea name="mensaje" id="mensaje" class="form-control" rows="3" placeholder="Escriba su mensaje..."></textarea>
                        </div>
                    </div>

                    <input name="responsable" id="responsable" type="hidden" class="form-control">
                    <input name="tipo" id="tipo" type="hidden" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="enviarEmailInforme()" data-dismiss="modal" class="btn btn-info-custom">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>