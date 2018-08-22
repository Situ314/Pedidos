<div id="verItemsPedidoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Items</h4>
            </div>
            <div id="bodyPedido" class="modal-body">
                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel-items-listado">
                        <div class="panel-heading">
                            <h4 class="panel-title row">
                                <a class="panel-title-titulo" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Items Solicitados
                                </a>
                                <div class="pull-right">
                                    <a id="btnImprimirItemsSolicitados" href="{{route('impimir.pedido.solicitados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank"><i class="fa fa-print"></i></a>
                                </div>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div id="panel-body-items" class="panel-body">
                            </div>
                        </div>
                    </div>
                    <div class="panel-items-listado">
                        <div class="panel-heading">
                            <h4 class="panel-title row">
                                <a class="panel-title-titulo" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                                    Items a Entregar
                                </a>
                                <div class="pull-right">
                                    <a id="btnImprimirItemsEntregar" href="{{route('impimir.pedido.entregados',':id')}}" class="btn btn-sm btn-primary-custom" target="_blank"><i class="fa fa-print"></i></a>
                                </div>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div id="panel-body-items-entregado" class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>