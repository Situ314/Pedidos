/**
 * Created by djauregui on 28/12/2017.
 */
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
        $('#unidad_id'+i).select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val(config.variables[0].item_pedido_temp[i].item.unidad_id).trigger('change');
    }
}