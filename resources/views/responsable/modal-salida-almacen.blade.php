<!-- Modal Consulta -->
<div id="modalSalidaAlmacen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button style="font-size: 24px; color: white;" type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-info"> INFORMACIÓN</i></h4>
            </div>
            <div id="modalBodySalidaAlmacen" class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-responsive">
                        <tbody>
                        <tr>
                            <th width="10%;">Empresa</th>
                            <td colspan="3"><p id="txtEmpresaSalida"></p></td>
                            <th rowspan="2" class="text-center" style="vertical-align: middle; font-size: 20px;">SALIDA DE ALMACEN</th>
                            <th width="4%;">N°</th>
                            <td colspan="3"><span id="txtNum"></span></td>
                        </tr>
                        <tr>
                            <th>O.T.<td>
                                <p id="txtOTSalida" style="font-weight: normal !important;"></p>
                            </td>
                            <td style="font-weight: bold;"># Pedido</td>
                            <td><span id="txtNumSolicitudSalida"></span></td>
                            <th width="6%;">Fecha</th>
                            <td><span id="txtFechaSalida"></span></td>
                            <th width="6%;">Hora</th>
                            <td><span id="txtHoraSalida"></span></td>
                        </tr>
                        <tr>
                            <td colspan="9" style="font-weight: bold;">
                                Solicitado por: <span id="txtSolicitanteSalida" style="font-weight: normal !important;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" style="font-weight: bold;">
                                Para el area de: <span id="txtAreaSalida" style="font-weight: normal !important;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" style="font-weight: bold;">
                                Proyecto: <span id="txtProyectoSalida" style="font-weight: normal !important;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" style="font-weight: bold;">
                                Responsable: <span id="txtResponsableSalida" style="font-weight: normal !important;"></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" style="font-weight: bold;">
                                Delivery: <span id="txtCourrierSalida" style="font-weight: normal !important;"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-responsive">
                        <thead>
                        <tr>
                            <th colspan="5">DATOS DE LOS PRODUCTOS</th>
                        </tr>
                        <tr>
                            <th width="6%;">Item</th>
                            <th>Detalle</th>
                            <th>Cantidad</th>
                            <th>U.M.</th>
                            <th>Observación</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyItemsSalidaAlmacen">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnConfirmacionSalidaAlmacen" type="button" class="btn btn-success-custom"><i class="fa fa-check"> Si</i></button>
                <button id="btnCancelarModal" type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"> No</i></button>
            </div>
        </div>

    </div>
</div>