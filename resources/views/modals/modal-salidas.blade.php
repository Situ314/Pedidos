<div id="verSalidasPedidoModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                @if(\Illuminate\Support\Facades\Auth::user()->rol_id == 4)
                    <h4 class="modal-title">Salidas Almacen</h4>
                @else
                    <h4 class="modal-title">Informe Entrega</h4>
                @endif
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionSalidaItems" role="tablist" aria-multiselectable="true">
                    {{--<div id="filepdf" hidden></div>--}}
                </div>
            </div>
            <div id="footerModalSalidaPedido" class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
</div>