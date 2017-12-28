/**
 * Created by djauregui on 18/12/2017.
 */
function modalDevolver(opt) {
    console.log(opt);
    $('#modalDevolucionHeader').removeClass('modal-header-primary');
    $('#modalDevolucionHeader').removeClass('modal-header-danger');

    $('#modalDevolucionTitle').empty();

    $('#btnAceptarDevolucion').removeClass('btn-primary-custom');
    $('#btnAceptarDevolucion').removeClass('btn-danger-custom');

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
            $('#modalDevolucionHeader').addClass('modal-header-danger');
            $('#modalDevolucionTitle').append('<i class="fa fa-pause"></i> En Espera');

            $('input[name=tipo_dev]').val(3);

            $('#btnAceptarDevolucion').addClass('btn-danger-custom');
            $('#btnAceptarDevolucion').text("En Espera");
            break;
    }
    $('#modalDevolucion').modal('show');
}