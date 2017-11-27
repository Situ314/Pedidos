/**
 * Created by djauregui on 24/11/2017.
 */
var options_categorias = "";
var option_unidades = "";
$( document ).ready(function() {
    $('.js-placeholder-single').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');

    $('.items-select2').select2({
        allowClear: true,
        placeholder: "Primero seleccione una categoria...",
        width: '100%'
    }).val('').trigger('change');
    $('.items-select2').prop('disabled', true);

    getEmpresas();

    getUnidades();

    $('select[name=empresa_id]').change(function () {
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

    });


    $('select[name=tipo_cat_id]').change(function () {
        var selected_op = $(this).find('option:selected').val();
        if(typeof selected_op != "undefined"){
            var categorias = config.variables[0].categorias;
            options_categorias = "";
            for(var i=0;i<categorias.length;i++){
                if(selected_op == categorias[i].tipo_categoria_id){
                    console.log(categorias[i]);
                    options_categorias += "<option value='"+categorias[i].id+"'>"+categorias[i].nombre+"</option>";
                }
            }
            $('.items-select2').prop('disabled', false);
            $('.items-select2').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val('').trigger('change');

            $('.items-select2').empty();
            $('.items-select2').append(options_categorias);
        }else{
            $('.items-select2').select2({
                allowClear: true,
                placeholder: "Primero seleccione una categoria...",
                width: '100%'
            }).val('').trigger('change');
            $('.items-select2').prop('disabled', true);
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
        console.log(unidades[i]);
        option_unidades += "<option value='"+unidades[i].id+"'>"+unidades[i].nombre+"("+unidades[i].descripcion+")</option>"
    }
    // console.log(option_unidades);
}
function agregarItem() {
    // console.log("Agregando...");
    var tr = "<tr>";
        tr+="<td scope='row'>2</td>"+
            "<td><select name='unidad_id[]' class='js-placeholder-single'>"+option_unidades+"</select></td>"+
            "<td><input name='cantidad[]' type='number' step='0.1' class='form-control'></td>"+
            "<td><select name='item_id[]' class='items-select2'>"+options_categorias+"</select></td>"+
            "<td><i class='fa fa-close' onclick='javascript:eliminarFila(this);'></i></td>";
    tr += "</tr>";
    $('#tbodyItems').append(tr);
}

function eliminarFila(obj) {
    console.log(obj);
    $(obj).parent().parent().remove();
}