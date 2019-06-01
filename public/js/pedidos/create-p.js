/**
 * Created by djauregui on 24/11/2017.
 */
// var options_categorias = "";
var option_unidades = "";
var option_tipo_compras = "";
var options_items = "";
var options_proyectos = "";
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
    $('input').on('keydown', function(event) {
        var x = event.which;
        if (x === 13) {
            event.preventDefault();
        }
    });

    getUnidades();
    getTipoCompras();
    // getEmpleados();

    $('select[name=tipo_cat_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined"){

            if(selected_op == '20'){
                console.log("TIPOOOOO"+selected_op);
                $('td[id=td_obs]').show();
                $('th[id=th_obs]').show();
            }else{
                $('td[id=td_obs]').hide();
                $('th[id=th_obs]').hide();
            }
            // var categorias = config.variables[0].categorias;
            var items = config.variables[0].items;
            // options_categorias = "";
            options_items = "";
            // for(var i=0;i<categorias.length;i++){
            for(var i=0;i<items.length;i++){
                if(selected_op == items[i].tipo_categoria_id){
                    // options_categorias += "<option value='"+categorias[i].id+"'>"+categorias[i].nombre+"</option>";
                    options_items += "<option value='"+items[i].id+"' data-unidad='"+items[i].unidad_id+"' data-compra='"+items[i].tipo_compra_id+"'>"+items[i].nombre+"</option>";
                }
            }
            $('.items-select2').prop('disabled', false);
            $('#btnAgregarItem').prop('disabled', false);
            $('#btnAgregarItem').prop('title','Agregar item');

            $('.btnCambiarEditSelect').removeClass('disabled');

            $('.items-select2').empty();
            // $('.items-select2').append(options_categorias);
            $('.items-select2').append(options_items);


            for(var i=0;i<$('.items-select2').parent().length;i++){

                if($($('.items-select2').parent()[i]).data('content')==0){ //ES SELECT
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

                if($($('.items-select2').parent()[i]).data('content')==0){ //ES SELECT
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

    //CUANDO CAMBIA LA EMPRESA
    $('select[name=empresa_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined") {

            options_proyectos = "";
            var proyectos_s = proyectos_solicitudes.pr;
            console.log(proyectos_s);

            for(var i=0 ; i<proyectos_s.length ; i++){

                if(selected_op == proyectos_s[i].empresa_id){
                    var proyecto_full = "";
                    options_proyectos += '<option value="'+proyectos_s[i].id+'" data-emp="'+proyectos_s[i].empresa_id+'">'+proyectos_s[i].padre.nombre+' &#10148 '+proyectos_s[i].nombre+'</option>';
                    // if(proyectos_s[i].padre == null)
                    //     options_proyectos += '<option value="'+proyectos_s[i].id+'" data-emp="'+proyectos_s[i].empresa_id+'">'+proyectos_s[i].nombre+'</option>';
                    // else
                    //     options_proyectos += '<option value="'+proyectos_s[i].id+'" data-emp="'+proyectos_s[i].empresa_id+'">'+proyectos_s[i].padre.nombre+' &#10148 '+proyectos_s[i].nombre+'</option>';
                }
            }
            if(!jQuery.isEmptyObject(proyectos_empleado)){ //TODOS LOS PROYECTOS ESTAN EM SOLICITUDES INCLUIDO EL SUYO
                var proyecto_e = proyectos_empleado.pr;
                console.log(proyectos_empleado);
                if(selected_op == proyecto_e.empresa_id){
                    options_proyectos += '<option value="'+proyecto_e.id+'" data-emp="'+proyecto_e.empresa_id+'">'+proyecto_e.nombre+'</option>';
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
            select_empresas.append("<option value='"+val['id']+"|"+val['nombre']+"|"+val['razon']+"' data-foo='"+val['id']+"'>"+val['nombre']+"</option>");

            $.each(val['proyecto'], function (key2, val2) {
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
        option_unidades += "<option value='"+unidades[i].id+"'>"+unidades[i].nombre+" ("+unidades[i].descripcion+")</option>"
    }
}

function getTipoCompras() {
    var tipo_compras = config.variables[0].tipo_compras;
    for(var i = 0; i<tipo_compras.length ; i++){
        option_tipo_compras += "<option value='"+tipo_compras[i].id+"'>"+tipo_compras[i].nombre+"</option>"
    }
}

var auxU = 1;
function agregarItem() {
    var tr = "<tr>";
    var selected_op = $('select[name=tipo_cat_id]').find('option:selected').val();
    console.log(selected_op);
    if(selected_op == '20'){
        tr+="<th scope='row'>"+(auxU+1)+"</th>"+
            // "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required>"+options_categorias+"</select></td>"+
            "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' onkeyup='javascript:buscarItem(this.value,"+auxU+");'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required onchange='javascript:cambiarUnidad("+auxU+");'>"+options_items+"</select></td>"+
            "<td><input name='cantidad[]' type='number' step='0.1' class='form-control input-hg-12' min='0.1' required></td>"+
            "<td><input name='txtUnidad[]' id='txtUnidad"+auxU+"' class='hidden'/><select name='unidad_id[]' id='unidad_id"+auxU+"' class='js-placeholder-single' required disabled onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_unidades+"</select></td>"+
            "<td><input name='tipoCompra[]' id='txtTipoCompra"+auxU+"' class='hidden'/><select name='tipo_compra_id[]' id='tipo_compra_id"+auxU+"' class='js-placeholder-single' required onchange='javascript:cambiarTextoTipoCompra("+auxU+");'>"+option_tipo_compras+"</select></td>"+
            "<td width=\"30%\"><input name='observacion[]' id='txtObs"+auxU+"' type='text' style=\"text-transform:uppercase\" class='form-control input-hg-12 items-txt text-uppercase'></td>"+
            "<td>" +
            "<a class='editar btnCambiarEditSelect' onclick='javascript:editarCampo("+auxU+");' title='Editar item "+(auxU+1)+"'><i id='i"+auxU+"' class='fa fa-edit'></i></a>" +
            "<a class='eliminar' onclick='javascript:eliminarFila(this);' title='Eliminar item "+(auxU+1)+"'><i class='fa fa-close'></i></a>"+
            "</td>";
    }else{
        tr+="<th scope='row'>"+(auxU+1)+"<input name='observacion[]' id=\"txtObs\" type='text' style=\"text-transform:uppercase\" class='form-control input-hg-12 hidden'></th>"+
            // "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required>"+options_categorias+"</select></td>"+
            "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' onkeyup='javascript:buscarItem(this.value,"+auxU+");'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required onchange='javascript:cambiarUnidad("+auxU+");'>"+options_items+"</select></td>"+
            "<td><input name='cantidad[]' type='number' step='0.1' class='form-control input-hg-12' min='0.1' required></td>"+
            "<td><input name='txtUnidad[]' id='txtUnidad"+auxU+"' class='hidden'/><select name='unidad_id[]' id='unidad_id"+auxU+"' class='js-placeholder-single' required disabled onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_unidades+"</select></td>"+
            "<td><input name='tipoCompra[]' id='txtTipoCompra"+auxU+"' class='hidden'/><select name='tipo_compra_id[]' id='tipo_compra_id"+auxU+"' class='js-placeholder-single' required onchange='javascript:cambiarTextoTipoCompra("+auxU+");'>"+option_tipo_compras+"</select></td>"+
            "<td>" +
            "<a class='editar btnCambiarEditSelect' onclick='javascript:editarCampo("+auxU+");' title='Editar item "+(auxU+1)+"'><i id='i"+auxU+"' class='fa fa-edit'></i></a>" +
            "<a class='eliminar' onclick='javascript:eliminarFila(this);' title='Eliminar item "+(auxU+1)+"'><i class='fa fa-close'></i></a>"+
            "</td>";
    }

    tr += "</tr>";
    $('#tbodyItems').append(tr);

    $('#unidad_id'+auxU).select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
    $('#tipo_compra_id'+auxU).select2({
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

function cambiarUnidad(id) {
    if(typeof $('#item_id'+id).find('option:selected').val()!="undefined"){

        $('#unidad_id'+id).prop('disabled', true);
        $('#unidad_id'+id).select2({
            allowClear: true,
            placeholder: "Primero seleccione una categoria...",
            width: '100%'
        }).val($('#item_id'+id).find('option:selected').data('unidad')).trigger('change');

        $('#tipo_compra_id'+id).prop('disabled', false);
        $('#tipo_compra_id'+id).select2({
            allowClear: true,
            placeholder: "Seleccione un tipo de compra...",
            width: '100%'
        }).val($('#item_id'+id).find('option:selected').data('compra')).trigger('change');
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

    if(typeof $('#unidad_id'+id).find('option:selected').val()!="undefined"){
        $('#txtUnidad'+id).val($('#unidad_id'+id).find('option:selected').val());
    }else{
        $('#txtUnidad'+id).val(0);
    }
}

function cambiarTextoTipoCompra(id) {

    if(typeof $('#tipo_compra_id'+id).find('option:selected').val()!="undefined"){
        $('#txtTipoCompra'+id).val($('#tipo_compra_id'+id).find('option:selected').val());
    }else{
        $('#txtTipoCompra'+id).val(0);
    }
}

//FUNCIONES PARA DOCUMENTOS
var auxD = 1;
function agregarDocumento() {
    if( $('table#tableDoc').hasClass('hidden') ){
        $('table#tableDoc').removeClass('hidden');
    }

    $('#advertencia_size').hide();
    var tr = '<tr>' +
        '<td scope="row" width="2%;">'+auxD+'</td>'+
        '<td><input name="doc[]" id="inputFile'+auxD+'" class="hidden" onchange="mostrarNombre(this, '+auxD+');" type="file"><p id="fileName'+auxD+'"></p></td>'+
        '<td><p id="fileSize'+auxD+'"></p></td>'+
        '<td><a class="eliminar" onclick="eliminarFila(this);"><i class="fa fa-close"></i></a></td>'+
        '</tr>';

    $('tbody#tbodyDoc').append(tr);

    $('#inputFile'+auxD).trigger('click');

    auxD++;
}

function mostrarNombre(obj, id) {
    console.log(obj);
    console.log(obj.files);
    console.log(obj.files.item(0).name);
    console.log(obj.files.item(0).size);
    if(obj.files.item(0).size > 5e+7){
        $('#advertencia_size').show();
        eliminarFila(obj);
    }else{
        console.log(getReadableFileSizeString(obj.files.item(0).size));
        $('#fileName'+id).text( obj.files.item(0).name );
        $('#fileSize'+id).text( getReadableFileSizeString(obj.files.item(0).size) );
    }

}