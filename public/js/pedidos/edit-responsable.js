/**
 * Created by djauregui on 28/12/2017.
 */
var arrayMeses = {
    0: 'Enreo',
    1: 'Febrero',
    2: 'Marzo',
    3: 'Abril',
    4: 'Mayo',
    5: 'Junio',
    6: 'Julio',
    7: 'Agosto',
    8: 'Septiembre',
    9: 'Octubre',
    10: 'Noviembre',
    11: 'Diciembre'
};
$(document).ready(function(){
    //HABILITANDO EL iCheck
    $('.icheck_class').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    //CAMBIO DE VALORES EL LOS INPUT HIDDEN
    $('.icheck_class').on('ifClicked', function(event){
        var valor = this.id.split('radio_entrega_');
        console.log(valor[1]);
        if($('#inputRadio'+valor[1]).val()==0)
            $('#inputRadio'+valor[1]).val(1);
        else
            $('#inputRadio'+valor[1]).val(0);
    });

    //PREVENCION DE ENVIO DE FORMULARIO
    $("#formUpdateResponsable").submit(function(e, submit){

        if(!submit)
            e.preventDefault(e);

        var token = config.rutas[0].token;
        var route = config.rutas[0].salidaMax;

        console.log( $('input[name^=input_radio_entrega]') );

        var aux_cont = 0;
        for(var i=0 ; i<$('input[name^=input_radio_entrega]').length ;i++){
            if( $('#inputRadio'+i).val()==0 ){
                aux_cont++;
            }
        }

        if($('input[name^=input_radio_entrega]').length == aux_cont){
            modal_info("<i class='fa fa-warning'></i> ADVERTENCIA","modal-header-warning","No selecciono ningun item a entregar");
        }else{
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function(e){
                }
            }).done(function (response){
                //CARGANDO DATOS DE GENERALES DE SALIDA DE ALMACEN
                if(response.id > 0)
                    $('#txtNum').text(parseInt( (response.id)+1) );
                else
                    $('#txtNum').text(1);

                $('#txtEmpresaSalida').text( $('#txtEmpresa').text() );
                $('#txtOTSalida').text( $('input[name=num_ot]').val() );

                $('#txtFechaSalida').text( moment().format('DD')+'/'+arrayMeses[moment().month()]+'/'+moment().format('YYYY') );
                $('#txtHoraSalida').text( moment().format('HH::mm') );

                $('#txtSolicitanteSalida').text( $('#txtSolicitante').text() );
                $('#txtAreaSalida').text( $('input[name=area]').val().toUpperCase() );
                $('#txtProyectoSalida').text( $('#txtProyecto').text() );
                //************************************

                //CARGANDO ITEMS DE SALIDA DE ALMACEN
                var tbody = "";
                var aux = 1;
                for(var i=0 ; i<$('input[name^=input_radio_entrega]').length ;i++){
                    if( $('#inputRadio'+i).val()==1 ){
                        tbody += '<tr>'+
                                    '<th scope="row">'+aux+'</th>'+
                                    '<td>'+$('#item_id'+i+' option:selected').text()+'</td>'+
                                    '<td>'+$('#numCantidad'+i).val()+'</td>'+
                                    '<td>'+$('#unidad_id'+i+' option:selected').text()+'</td>'+
                                '</tr>';

                        aux++;
                        console.log( $('#numCantidad'+i).val() );
                    }
                }

                $('#tbodyItemsSalidaAlmacen').empty();
                $('#tbodyItemsSalidaAlmacen').append(tbody);

                //************************************
                $('#modalSalidaAlmacen').modal('show');
            });
        }
    });

    //BOTON DE DESPLIEGUE DE MODAL DE MUESTRA DE DOCUMENTO DE SALIDA
    $('#btnConfirmacionSalidaAlmacen').click(function () {
        console.log("Acepto...");
        $('#formUpdateResponsable').trigger('submit', [true]);
    });
});

function edicion(){
    auxU = parseInt(config.variables[0].cantItem);

    var cantItem = config.variables[0].cantItemEntrega;

    $('.select_unidad_temp').prop('disabled',false);

    for(var i=0; i<cantItem ; i++){
        $('#item_id'+i).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val(config.variables[0].items_entrega[i].item_id).trigger('change');
    }

    for(var i=0;i<cantItem;i++){
        // console.log(config.variables[0].items_entrega[i].item.unidad_id);

        $('#unidad_id'+i).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val(config.variables[0].items_entrega[i].item.unidad_id).trigger('change');
    }

    //OCULTANDO EL SELECT DE CATEGORIA
    $('select[name=tipo_cat_id]').select2({
        containerCssClass: "hidden"
    });

    //DESHABILITANDO ITEMS
    $('.items-select2').prop('disabled', true);

    //RESPONSABLE EN BLANCO
    $('select[name=responsable_entrega_id]').select2({
        allowClear: true,
        placeholder: "Seleccione responsable de entrega...",
        width: '100%'
    }).val('').trigger('change');
}

function modal_info(titulo, clase_header, contenido) {
    $('#titleModalInfo').html(titulo);
    $('#bodyModalInfo').empty();
    $('#bodyModalInfo').append(contenido);

    $('#infoModalHeader').removeClass("modal-header-default");
    $('#infoModalHeader').removeClass("modal-header-primary");
    $('#infoModalHeader').removeClass("modal-header-info");
    $('#infoModalHeader').removeClass("modal-header-info-dark");
    $('#infoModalHeader').removeClass("modal-header-danger");
    $('#infoModalHeader').removeClass("modal-header-warning");

    $('#infoModalHeader').addClass(clase_header);


    $('#modalInfo').modal('show');
}