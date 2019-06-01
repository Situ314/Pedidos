<!-- MODAL DE BUSQUEDA -->
<div id="modalBuscarItem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-search"></i> Buscar Item</h4>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input id="txtBucarItem" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" onclick="buscarItemCategoria();" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
                <div id="advertencia" hidden class="alert alert-danger alert-dismissible fade in" role="alert">
                    {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>--}}
                    {{--</button>--}}
                    No se puede agregar el item porque no pertenece a la misma categoría.
                </div>
                {{--<p id="advertencia" hidden style="color: darkred"> No se puede agregar el item porque no pertenece a la misma categoría. </p>--}}
                <div id="contenido-busqueda"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>