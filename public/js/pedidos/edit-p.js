/**
 * Created by djauregui on 19/12/2017.
 */
var option_unidades = "";
var options_items = "";

$( document ).ready(function() {
    $('.js-placeholder-single').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    });

    $('.items-select2').prop('disabled', true);

    getUnidades();

    var auxItems = false;

    $('select[name=tipo_cat_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined"){
            var items = config.variables[0].items;
            options_items = "";

            for(var i=0;i<items.length;i++){
                if(selected_op == items[i].tipo_categoria_id){
                    options_items += "<option value='"+items[i].id+"' data-unidad='"+items[i].unidad_id+"'>"+items[i].nombre+"</option>";
                }
            }

            $('.items-select2').prop('disabled', false);
            $('#btnAgregarItem').prop('disabled', false);
            $('#btnAgregarItem').prop('title','Agregar item');

            $('.btnCambiarEditSelect').removeClass('disabled');

            $('.items-select2').empty();
            $('.items-select2').append(options_items);

            for(var i=0;i<$('.items-select2').parent().length;i++){
                // console.log( $('.items-select2').parent()[i] );
                // console.log( $($('.items-select2').parent()[i]).data('content') );

                if($($('.items-select2').parent()[i]).data('content')==0){ //ES SELECT
                    console.log($('.items-select2').parent()[i].id);
                    console.log($('.items-select2').parent()[i].id.slice(2));
                    var num = $('.items-select2').parent()[i].id.slice(2);
                    $('#item_id'+num).select2({
                        allowClear: true,
                        placeholder: "Seleccione...",
                        width: '100%'
                    }).val('').trigger('change');
                }
            }

            $('.items-txt').prop('disabled', false);

        }else{
            for(var i=0;i<$('.items-select2').parent().length;i++){
                // console.log( $('.items-select2').parent()[i] );
                // console.log( $($('.items-select2').parent()[i]).data('content') );

                if($($('.items-select2').parent()[i]).data('content')==0){ //ES SELECT
                    console.log($('.items-select2').parent()[i].id);
                    console.log($('.items-select2').parent()[i].id.slice(2));
                    var num = $('.items-select2').parent()[i].id.slice(2);
                    $('#item_id'+num).select2({
                        allowClear: true,
                        placeholder: "Primero seleccione una categoria...",
                        width: '100%'
                    }).val('').trigger('change');
                }
            }

            $('.items-select2').prop('disabled', true);
            $('#btnAgregarItem').prop('disabled', true);
            $('#btnAgregarItem').prop('title','Primero seleccione un tipo de categoria');

            $('.btnCambiarEditSelect').addClass('disabled');

            $('.items-txt').prop('disabled', true);
        }
    });

    $('select[name=tipo_cat_id]').select2({
        allowClear: true,
        placeholder: "Primero seleccione una categoria...",
        width: '100%'
    }).val(parseInt(config.variables[0].categoriaSelect)).trigger('change');

    //********************************SECCION QUE CORRIGE Y PERMITE LA EDICION
    edicion();
});

var options_proyectos = "";

function getUnidades() {
    var unidades = config.variables[0].unidades;
    for(var i = 0; i<unidades.length ; i++){
        option_unidades += "<option value='"+unidades[i].id+"'>"+unidades[i].nombre+" ("+unidades[i].descripcion+")</option>"
    }
}

function eliminarFila(obj) {
    console.log(obj);
    $(obj).parent().parent().remove();
}

function editarCampo(id) {
    var select_td = "#td"+id;

    if($(select_td).data("content")==0){ //ES SELECT - CAMBIAR A TEXTO
        $('#item_id'+id).prop("required", false);
        $('#item_id'+id).select2({
            containerCssClass: "hidden"
            // dropdownCssClass: "test"
        }).val('').trigger('change');

        $('#txtItem'+id).prop("required",true);
        $('#txtItem'+id).removeClass("hidden");

        $(select_td).data("content",1);

        $('#i'+id).removeClass("fa-edit");
        $('#i'+id).addClass("fa-chevron-circle-down");

        $('#unidad_id'+id).prop('disabled', false);

    }else { //ES TEXTO - CAMBIAR A SELECT
        $('#item_id' + id).prop("required", true);
        $('#item_id' + id).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val('').trigger('change');

        $('#txtItem' + id).prop("required", false);
        $('#txtItem' + id).addClass("hidden");

        $(select_td).data("content", 0);

        $('#i' + id).removeClass("fa-chevron-circle-down");
        $('#i' + id).addClass("fa-edit");

        $('#unidad_id'+id).prop('disabled', true);
    }
}

//AQUI YACE EL ERROR DE LAS UNIDADES
function cambiarUnidad(id) {
    // console.log("Select cambiar unidad: "+id);

    if(typeof $('#item_id'+id).find('option:selected').val()!="undefined"){

        $('#unidad_id'+id).prop('disabled', true);
        $('#unidad_id'+id).select2({
            allowClear: true,
            placeholder: "Primero seleccione una categoria...",
            width: '100%'
        }).val($('#item_id'+id).find('option:selected').data('unidad')).trigger('change');
    }else{
        $('#unidad_id'+id).prop('disabled', true);
        $('#unidad_id'+id).select2({
            allowClear: true,
            placeholder: "Primero seleccione una categoria...",
            width: '100%'
        }).val('').trigger('change');
    }
}

function cambiarTextoUnidad(id) {
    // console.log("Select unidad: " + id);

    if (typeof $('#unidad_id' + id).find('option:selected').val() != "undefined") {
        console.log("Unidad: "+$('#item_id' + id).find('option:selected').data('unidad'));
        $('#txtUnidad' + id).val($('#unidad_id' + id).find('option:selected').val());
    } else {
        $('#txtUnidad' + id).val(0);
    }
}
