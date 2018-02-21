<!-- Modal -->
<div id="modalUsuarios" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-info">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-users"></i> Modal Equipo</h4>
            </div>
            <div id="modalBodyUsuarios" class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 profile_details">
                        <div class="well profile_view">
                            <div class="col-sm-12">
                                <h4 class="brief control-label"><i>Cargo</i></h4>
                                <div class="left col-xs-7">
                                    <h2 class="control-label">Nombre</h2>
                                    <p><strong>Lugar: </strong> Empresa / Proyecto </p>
                                    <ul class="list-unstyled">
                                        <li class="control-label"><i class="fa fa-building"></i> Dirección: </li>
                                        <li class="control-label"><i class="fa fa-phone"></i> Teléfono #: </li>
                                    </ul>
                                </div>
                                <div class="right col-xs-5 text-center">
                                    <img src="{{asset('images/user.png')}}" alt="" class="img-circle img-responsive">
                                </div>
                            </div>
                            <div class="col-xs-12 bottom text-center">
                                <div class="col-xs-12 col-sm-6 emphasis">
                                    <button type="button" class="btn btn-info-custom btn-xs">
                                        <i class="fa fa-edit"> </i> Cambiar de equipo
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            </div>
        </div>

    </div>
</div>