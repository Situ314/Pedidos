/**
 * Created by djauregui on 24/11/2017.
 */
// var options_categorias = "";
var option_unidades = "";
var options_items = "";

$( document ).ready(function() {
    $('.js-placeholder-single').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');

    $('.items-select2').select2({
        allowClear: true,
        placeholder: "Primero seleccione un tipo de pedido...",
        width: '100%'
    }).val('').trigger('change');
    $('.items-select2').prop('disabled', true);

    // getEmpresas();

    getUnidades();

    // getEmpleados();

    /*$('select[name=empresa_id]').change(function () {
        var select_proyectos = $('select[name=proyecto_id]');

        console.log($(this).find('option:selected').data('foo'));
        var selected_empresa = $(this).find('option:selected').data('foo');
        if(typeof selected_empresa!='undefined'){
            select_proyectos.empty();
            select_proyectos.append(options_proyectos);

            var select_proyectos_options = $('select[name=proyecto_id] option');

            select_proyectos_options.each(function (index, value) {
                // console.log(index);
                // console.log(value);
                // console.log($(value).data('foo'));
                // console.log("Empresa: "+$(this).data('foo'));
                if(selected_empresa != $(value).data('foo')){
                    // console.log("no es igual")
                    $(value).remove();
                }
            });

            select_proyectos.prop('disabled', false);
            select_proyectos.select2({
                allowClear: true,
                placeholder: "Seleccione un proyecto ...",
                width: '100%'
            }).val('').trigger('change');
        }else{
            select_proyectos.prop('disabled', true);
            select_proyectos.select2({
                allowClear: true,
                placeholder: "Primero seleccione una empresa ...",
                width: '100%'
            }).val('').trigger('change');
        }

    });*/

    $('select[name=tipo_cat_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined"){
            // var categorias = config.variables[0].categorias;
            var items = config.variables[0].items;
            // options_categorias = "";
            options_items = "";
            // for(var i=0;i<categorias.length;i++){
            for(var i=0;i<items.length;i++){
                if(selected_op == items[i].tipo_categoria_id){
                    // console.log(items[i]);
                    // options_categorias += "<option value='"+categorias[i].id+"'>"+categorias[i].nombre+"</option>";
                    options_items += "<option value='"+items[i].id+"' data-unidad='"+items[i].unidad_id+"'>"+items[i].nombre+"</option>";
                }
            }
            $('.items-select2').prop('disabled', false);
            $('#btnAgregarItem').prop('disabled', false);
            $('#btnAgregarItem').prop('title','Agregar item');

            $('.btnCambiarEditSelect').removeClass('disabled');

            $('.items-select2').empty();
            // $('.items-select2').append(options_categorias);
            $('.items-select2').append(options_items);

            console.log($('.items-select2').parent());
            console.log($('.items-select2').parent().length);

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
                        placeholder: "Primero seleccione un tipo de pedido...",
                        width: '100%'
                    }).val('').trigger('change');
                }
            }

            /*$('.items-select2').select2({
                allowClear: true,
                placeholder: "Primero seleccione una categoria...",
                width: '100%'
            }).val('').trigger('change');*/

            $('.items-select2').prop('disabled', true);
            $('#btnAgregarItem').prop('disabled', true);
            $('#btnAgregarItem').prop('title','Primero seleccione un tipo de categoria');

            $('.btnCambiarEditSelect').addClass('disabled');

            $('.items-txt').prop('disabled', true);
        }


    });
});

var options_proyectos = "";
function getEmpresas() {
    $.ajax({
        url: 'http://solicitudes.pragmainvest.com.bo/servicios/empresas',
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function (e) {
            $('select[name=empresa_id]').prop('disabled', true);
            $('select[name=empresa_id]').select2({
                allowClear: true,
                placeholder: "Cargando empresas ...",
                width: '100%'
            }).val('').trigger('change');

            $('select[name=proyecto_id]').prop('disabled', true);
            $('select[name=proyecto_id]').select2({
                allowClear: true,
                placeholder: "Cargando proyectos ...",
                width: '100%'
            }).val('').trigger('change');
        }
    }).done(function (response) {
        var select_empresas = $('select[name=empresa_id]');
        select_empresas.empty();

        var select_proyectos = $('select[name=proyecto_id]');
        select_proyectos.empty();

        $.each(response['empresas'], function (key, val) {
           // console.log(key+"=>"+val);
           //  console.log(key+"=>"+val['nombre']);
            select_empresas.append("<option value='"+val['id']+"|"+val['nombre']+"|"+val['razon']+"' data-foo='"+val['id']+"'>"+val['nombre']+"</option>");

            $.each(val['proyecto'], function (key2, val2) {
                // console.log(val2['nombre']);
                options_proyectos += "<option value='"+val2['id']+"|"+val2['nombre']+"|"+val2['descripcion']+"' data-foo='"+val['id']+"'>"+val2['nombre']+"</option>";
            });
        });
        // select_proyectos.append(options_proyectos);

        select_empresas.prop('disabled', false);
        select_empresas.select2({
            allowClear: true,
            placeholder: "Seleccione empresa ...",
            width: '100%'
        }).val('').trigger('change');

    }).fail(function (response) {

    });
}

function getUnidades() {
    var unidades = config.variables[0].unidades;
    for(var i = 0; i<unidades.length ; i++){
        // console.log(unidades[i]);
        option_unidades += "<option value='"+unidades[i].id+"'>"+unidades[i].nombre+" ("+unidades[i].descripcion+")</option>"
    }
    // console.log(option_unidades);
}

function getEmpleados(){
    $.ajax({
        url: 'http://rrhh.pragmainvest.com.bo/servicios/get.empleados',
        method: 'GET',
        dataType: 'JSON',
        beforeSend: function(e){
            $("select#solicitante_id").select2({
                allowClear: true,
                placeholder: "Cargando destinos ...",
                width: '100%'
            }).val('').trigger('change');

            $('select#solicitante_id').prop('disabled', true);
        }
    }).done(function (response){
        var selectDestinos = $('select#solicitante_id');
        selectDestinos.empty();

        $.each(response['empleados'], function(key, value){
            selectDestinos.append("<option value='"+value['id']+"|"+value['nombres']+" "+value['ap']+" "+value['am']+"|"+value['email_corporativo']+"'>"+value['nombres']+" "+value['ap']+" "+value['am']+"</option>");
        });
        $('select#solicitante_id').prop('disabled', false);
        $("select#solicitante_id").select2({
            allowClear: true,
            placeholder: "Seleccione empleado ...",
            width: '100%'
        }).val('').trigger('change');

    }).fail(function (response){
        console.log(response);
    });
}

var auxU = 1;
function agregarItem() {
    // console.log("Agregando...");
    var tr = "<tr>";
        tr+="<td scope='row'>"+(auxU+1)+"</td>"+
            "<td><input name='txtUnidad[]' id='txtUnidad"+auxU+"' class='hidden'/><select name='unidad_id[]' id='unidad_id"+auxU+"' class='js-placeholder-single' required disabled onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_unidades+"</select></td>"+
            "<td><input name='cantidad[]' type='number' step='0.1' class='form-control input-hg-12' min='0.1' required></td>"+
            // "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required>"+options_categorias+"</select></td>"+
            "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' onkeyup='javascript:buscarItem(this.value);'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required onchange='javascript:cambiarUnidad("+auxU+");'>"+options_items+"</select></td>"+
            "<td>" +
            "<a class='editar btnCambiarEditSelect' onclick='javascript:editarCampo("+auxU+");'><i id='i"+auxU+"' class='fa fa-edit'></i></a>" +
            "<a class='eliminar' onclick='javascript:eliminarFila(this);'><i class='fa fa-close'></i></a>"+
            "</td>";
    tr += "</tr>";
    $('#tbodyItems').append(tr);

    $('#unidad_id'+auxU).select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
    $('#item_id'+auxU).select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');

    auxU++;
}

function eliminarFila(obj) {
    console.log(obj);
    $(obj).parent().parent().remove();
}

function editarCampo(id) {
    var select_td = "#td"+id;
    // console.log($(select_td).data("content"));

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

function cambiarUnidad(id) {
    // console.log("Select: "+id);
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
    console.log("Select item: "+id);

    if(typeof $('#unidad_id'+id).find('option:selected').val()!="undefined"){
        console.log($('#item_id'+id).find('option:selected').data('unidad'));
        $('#txtUnidad'+id).val($('#unidad_id'+id).find('option:selected').val());
    }else{
        $('#txtUnidad'+id).val(0);
    }
}