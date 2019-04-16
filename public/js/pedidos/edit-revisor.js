var option_unidades = "";
var options_items = "";
var option_tipo_compras = "";

$( document ).ready(function() {
    $('.js-placeholder-single').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    });

    $('.items-select2').prop('disabled', true);

    getUnidades();
    getTipoCompras();
    var auxItems = false;

    $('select[name=tipo_cat_id]').select2({
        allowClear: true,
        placeholder: "Primero seleccione una categoria...",
        width: '100%'
    }).val(parseInt(config.variables[0].categoriaSelect)).trigger('change');

    //********************************SECCION QUE CORRIGE Y PERMITE LA EDICION
    edicion();
});


function edicion(){
    auxU = parseInt(config.variables[0].cantItemTemp) + parseInt(config.variables[0].cantItem);

    $('.items-temp-select2').select2({
        containerCssClass: "hidden"
        // dropdownCssClass: "test"
    }).val('').trigger('change');
    $('.items-temp-select2').prop('required',false);

    var cantItem = config.variables[0].cantItem;
    var cantItemTemp = config.variables[0].cantItemTemp;

    var auxLoopItem = cantItemTemp;
    for(var i=0; i<cantItem ; i++){
        $('#item_id'+auxLoopItem).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val(config.variables[0].item_pedido[i].item_id).trigger('change');

        auxLoopItem++;
    }

    $('.select_unidad_temp').prop('disabled',false);
    for(var i=0;i<cantItemTemp;i++){
        console.log(config.variables[0].item_pedido_temp[i].item.unidad_id);

        $('#unidad_id'+i).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val(config.variables[0].item_pedido_temp[i].item.unidad_id).trigger('change');
    }

    //<<<----UNICAMENTE PARA EL ASIGNADOR
    $('select[name=responsable_id]').select2({
        allowClear: true,
        placeholder: "Seleccione...",
        width: '100%'
    }).val('').trigger('change');
}

function cambiarTipoCompra(sel, id, item){
    console.log(sel.value, id);
    var select_td = "#tdT"+id;

    if($(select_td).data("content")==0){
        if(sel.value == '3'){
            var new_td='<label class="label label-primary">No es un AF</label>';
        }else{
            var new_td="<input name=\"idReg[]\" value="+item+" hidden><input class=\"input-hg-12\" required=\"true\" id=\"stock"+id+"\" min=\"0\" name=\"stock[]\" type=\"number\">";
        }
        $(select_td).empty();
        $(select_td).append(new_td);
    }else{
        if(sel.value == '3'){
            var new_td='<label class="label label-primary">No es un AF</label>';
        }else{
            var new_td="<input name=\"idTemp[]\" value="+item+" hidden><input class=\"input-hg-12\" required=\"true\" id=\"stock"+id+"\" min=\"0\" name=\"stock_tmp[]\" type=\"number\">";
        }
        $(select_td).empty();
        $(select_td).append(new_td);
    }


}

function getTipoCompras() {
    var tipo_compras = config.variables[0].tipo_compras;
    for(var i = 0; i<tipo_compras.length ; i++){
        option_tipo_compras += "<option value='"+tipo_compras[i].id+"'>"+tipo_compras[i].nombre+"</option>"
    }
}