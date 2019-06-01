/**
 * Created by djauregui on 31/1/2018.
 */
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

$(function () {
    $('[data-toggle="popover"]').popover()
});

var options_proyectos = "";
$(document).ready(function(){
    //HABILITANDO EL iCheck
    $('.icheck_class').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });

    //CAMBIO DE VALORES EL LOS INPUT HIDDEN
    $('.icheck_class').on('ifClicked', function(event){
        var valor = this.id.split('radio_entrega_');
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

        var id = $('input[name^=input_radio_entrega]')[ $('input[name^=input_radio_entrega]').length-1 ].id;
        var tamaño = id.split('inputRadio');

        var aux_cont = 0;
        for(var i=0 ; i<=tamaño[1] ;i++){
            console.log("Iteracion: "+i);
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
                data:{
                    id: config.variables[0].ped,
                    empresa_id: config.variables[0].emp
                },
                beforeSend: function(e){
                }
            }).done(function (response){
                //CARGANDO DATOS DE GENERALES DE SALIDA DE ALMACEN
                $('#txtEmpresaSalida').text( $('#txtEmpresa').text() );
                $('#txtOTSalida').text( $('input[name=num_ot]').val() );

                $('#txtFechaSalida').text( moment().format('DD')+'/'+arrayMeses[moment().month()]+'/'+moment().format('YYYY') );
                $('#txtHoraSalida').text( moment().format('HH::mm') );

                $('#txtSolicitanteSalida').text( $('#txtSolicitante').text() );
                $('#txtAreaSalida').text( $('input[name=area]').val().toUpperCase() );
                $('#txtProyectoSalida').text( $('#txtProyecto').text() );

                $('#txtResponsableSalida').text( $('select[name=responsable_entrega_id] option:selected').text() );
                $('#txtCourrierSalida').text( $('select[name=courrier_id] option:selected').text() )

                if(response.num_solicitud == null){ //ES LA PRIMERA SALIDA
                    $('#txtNumSolicitudSalida').text( 1 );
                    $('input[name=num_solicitud]').val( 1 );
                }else{ //PERTENECE A SALIDA PARCIAL
                    $('#txtNumSolicitudSalida').text( response.num_solicitud );
                    $('input[name=num_solicitud]').val( response.num_solicitud );
                }
                //************************************

                //CARGANDO ITEMS DE SALIDA DE ALMACEN
                var tbody = "";
                var aux = 1;

                for(var i=0 ; i<=tamaño[1] ;i++){
                    console.log($('#inputRadio'+i));
                    if( $('#inputRadio'+i).length ){
                        console.log("existe "+i);
                    }else{
                        console.log("no existe "+i);
                    }

                    if( $('#inputRadio'+i).val()==1 ){
                        console.log("input-"+i);
                        tbody += '<tr>'+
                            '<th scope="row">'+aux+'</th>'+
                            '<td>'+$('#item_id'+i+' option:selected').text()+'</td>'+
                            '<td>'+$('#numCantidad'+i).val()+'</td>'+
                            '<td>'+$('#unidad_id'+i+' option:selected').text()+'</td>'+
                            '<td>'+$('#inputObs'+i).val().toUpperCase()+'</td>' +
                            '</tr>';

                        aux++;
                        // console.log( $('#numCantidad'+i).val() );
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

    //CAMBIO DE EMPRESA - CARGA NUEVOS PROYECTOS
    $('select[name=empresa_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined"){
            var proyectos = config.variables[0].proy;
            options_proyectos = "";

            for(var i=0;i<proyectos.length;i++){
                if(selected_op == proyectos[i].empresa_id){
                    console.log(proyectos[i]);
                    options_proyectos += "<option value='"+proyectos[i].id+"'>"+proyectos[i].nombre+"</option>";
                }
            }

            $('select[name=proyecto_id]').prop('disabled', false);
            $('select[name=proyecto_id]').empty();
            $('select[name=proyecto_id]').append(options_proyectos);

            $('select[name=proyecto_id]').select2({
                allowClear: true,
                placeholder: "Seleccione un proyecto...",
                width: '100%'
            }).val('').trigger('change');
        }else{
            $('select[name=proyecto_id]').prop('disabled', true);
            $('select[name=proyecto_id]').select2({
                allowClear: true,
                placeholder: "Seleccione una empresa...",
                width: '100%'
            }).val('').trigger('change');
        }
    });

    //EMPRESA - CARGA AUTOMATICAMENTE
    $('select[name=empresa_id]').select2({
        allowClear: true,
        placeholder: "Seleccione empresa...",
        width: '100%'
    }).val(parseInt(config.variables[0].emp)).trigger('change');

    //PROYECTO - CARGA AUTOMATICAMENTE
    $('select[name=proyecto_id]').select2({
        allowClear: true,
        placeholder: "Seleccione proyecto...",
        width: '100%'
    }).val(parseInt(config.variables[0].pr)).trigger('change');

    //COURRIER SELECT
    $('select[name=courrier_id]').select2({
        allowClear: true,
        placeholder: "Seleccione courrier o delivery...",
        width: '100%'
    }).val('').trigger('change');

    //ESTADO COMPRA SELECT
    $('select[name^=estado_tic_id]').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
});

function edicion(){
    auxU = parseInt(config.variables[0].cantItem);

    var cantItem = config.variables[0].cantItemEntrega;
    auxTic = parseInt(config.variables[0].cantItemEntregaTic);

    console.log("TIIIICS"+auxTic);
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
        if($('#unidad_id'+i).length){ //VERIFICA SI EXISTE EL ELEMENTO
            $('#unidad_id'+i).select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val(config.variables[0].items_entrega[i].item.unidad_id).trigger('change');
        }
    }

    //OCULTANDO EL SELECT DE CATEGORIA
    $('select[name=tipo_cat_id]').select2({
        containerCssClass: "hidden"
    });

    //DESHABILITANDO ITEMS
    $('.items-select2').prop('disabled', true);

    //OFICINA - CARGA AUTOMATICAMENTE
    $('select[name=oficina_id]').select2({
        allowClear: true,
        placeholder: "Seleccione proyecto...",
        width: '100%'
    }).val(parseInt(config.variables[0].ofi)).trigger('change');

    //RESPONSABLE EN BLANCO
    $('select[name=responsable_entrega_id]').select2({
        allowClear: true,
        placeholder: "Seleccione responsable de entrega...",
        width: '100%'
    }).val(parseInt(config.variables[0].usu)).trigger('change');

    //ESTADO COMPRA SELECT
    $('select[name^=estado_tic_id]').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
    //RESPONSABLE EN BLANCO
    // $('select[name=responsable_entrega_id]').select2({
    //     allowClear: true,
    //     placeholder: "Seleccione responsable de entrega...",
    //     width: '100%'
    // }).val('').trigger('change');
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