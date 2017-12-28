/**
 * Created by djauregui on 28/12/2017.
 */
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
        console.log(config.variables[0].items_entrega[i].item.unidad_id);

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
}