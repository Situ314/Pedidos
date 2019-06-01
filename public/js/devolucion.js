/**
 * Created by djauregui on 18/12/2017.
 */
function modalDevolver(opt) {
    $('#modalDevolucionHeader').removeClass('modal-header-primary');
    $('#modalDevolucionHeader').removeClass('modal-header-danger');
    $('#modalDevolucionHeader').removeClass('modal-header-warning');
    $('#modalDevolucionHeader').removeClass('modal-header-danger');

    $('#modalDevolucionTitle').empty();

    $('#btnAceptarDevolucion').removeClass('btn-primary-custom');
    $('#btnAceptarDevolucion').removeClass('btn-danger-custom');
    $('#btnAceptarDevolucion').removeClass('btn-warning-custom');

    switch (opt){
        case 1: //Rechazar
            $('#modalDevolucionHeader').addClass('modal-header-danger');
            $('#modalDevolucionTitle').append('<i class="fa fa-close"></i> Rechazar');

            $('input[name=tipo_dev]').val(1);

            $('#btnAceptarDevolucion').addClass('btn-danger-custom');
            $('#btnAceptarDevolucion').text("Rechazar");
            break;
        case 2: //Observar
            $('#modalDevolucionHeader').addClass('modal-header-primary');
            $('#modalDevolucionTitle').append('<i class="fa fa-arrow-left"></i> Devolver');

            $('input[name=tipo_dev]').val(2);

            $('#btnAceptarDevolucion').addClass('btn-primary-custom');
            $('#btnAceptarDevolucion').text("Observar");
            break;
        case 3: //EN ESPERA (SOLO PARA RESPONSABLES)
            $('#modalDevolucionHeader').addClass('modal-header-warning');
            $('#modalDevolucionTitle').append('<i class="fa fa-pause"></i> En Espera');

            $('input[name=tipo_dev]').val(3);

            $('#btnAceptarDevolucion').addClass('btn-warning-custom');
            $('#btnAceptarDevolucion').text("En Espera");
            break;
        case 4: //RETORNAR POR ACTIVO FIJO
            $('#modalDevolucionHeader').addClass('modal-header-info');
            $('#modalDevolucionTitle').append('<i class="fa fa-tag"></i> Devolver a Control de Activo Fijo');

            $('input[name=tipo_dev]').val(4);

            $('#btnAceptarDevolucion').addClass('btn-info-custom');
            $('#btnAceptarDevolucion').text("Observar por AF");
            break;
    }
    $('#modalDevolucion').modal('show');
}

function modalDevolverTic(){
    $('#modalDevolucionTicHeader').removeClass('modal-header-primary');
    $('#modalDevolucionTicHeader').removeClass('modal-header-danger');
    $('#modalDevolucionTicHeader').removeClass('modal-header-warning');
    $('#modalDevolucionTicHeader').removeClass('modal-header-danger');

    $('#modalDevolucionTicTitle').empty();

    $('#btnAceptarDevolucionTic').removeClass('btn-primary-custom');
    $('#btnAceptarDevolucionTic').removeClass('btn-danger-custom');
    $('#btnAceptarDevolucionTic').removeClass('btn-warning-custom');

    $('#modalDevolucionTicHeader').addClass('modal-header-primary');
    $('#modalDevolucionTicTitle').append('<i class="fa fa-laptop"></i> Derivar a TIC\'s');

    $('#btnAceptarDevolucionTic').addClass('btn-primary-custom');
    $('#btnAceptarDevolucionTic').text("Devolver a Control de TIC's");

    $('#modalDevolucionTic').modal('show');
}

function modalDevolverM(){
    $('#modalDevolucionMHeader').removeClass('modal-header-primary');
    $('#modalDevolucionMHeader').removeClass('modal-header-danger');
    $('#modalDevolucionMHeader').removeClass('modal-header-warning');
    $('#modalDevolucionMHeader').removeClass('modal-header-danger');

    $('#modalDevolucionMTitle').empty();

    $('#btnAceptarDevolucionM').removeClass('btn-primary-custom');
    $('#btnAceptarDevolucionM').removeClass('btn-danger-custom');
    $('#btnAceptarDevolucionM').removeClass('btn-warning-custom');

    $('#modalDevolucionMHeader').addClass('modal-header-primary');
    $('#modalDevolucionMTitle').append('<i class="fa fa-undo"></i> Derivar a Tepco');

    $('#btnAceptarDevolucionM').addClass('btn-primary-custom');
    $('#btnAceptarDevolucionM').text("Enviar a Tepco");

    $('#modalDevolucionM').modal('show');
}