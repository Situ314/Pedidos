/**
 * Created by djauregui on 23/12/2017.
 */
var auxU = 0;
function agregarItem() {
    console.log("Agregando.....");
    console.log(auxU);

    var tr = "<tr>";
    tr+="<th scope='row'>"+(auxU+1)+"<input name='item_id_edit[]' value='0' hidden></th>"+
        "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required onchange='javascript:cambiarUnidad("+auxU+");'>"+options_items+"</select></td>"+
        "<td><input name='cantidad[]' type='number' step='0.1' class='form-control input-hg-12' required></td>"+
        "<td><input type='number' step='0.1' class='form-control input-hg-12' disabled></td>"+
        "<td><input name='txtUnidad[]' id='txtUnidad"+auxU+"' class='hidden'/><select name='unidad_id[]' id='unidad_id"+auxU+"' class='js-placeholder-single' required onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_unidades+"</select></td>"+

        // "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required>"+options_categorias+"</select></td>"+
        "<td><label class='label label-default'>Item Nuevo</label></td>"+
        "<td><input name='tipoCompra[]' id='txtTipoCompra"+auxU+"' class='hidden'/><select name='tipo_compra_id[]' id='tipo_compra_id"+auxU+"' class='js-placeholder-single' required onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_tipo_compras+"</select></td>"+
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