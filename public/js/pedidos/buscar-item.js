/**
 * Created by djauregui on 13/8/2018.
 */
function buscarItemCategoria() {
    var route = config.rutas[0].buscarItem;
    var token = config.rutas[0].token;

    var texto = $('#txtBucarItem').val();
    if(!isEmptyOrSpaces(texto)){
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data:{
                nombre: texto
            },
            dataType: 'JSON',
            beforeSend: function(e){
                $('#contenido-busqueda').empty();
                $('#contenido-busqueda').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                    '<i class="fa fa-spin fa-spinner"></i><strong> Cargando</strong> items...'+
                    '</div>');
            }
        }).done(function (response){
            $('#contenido-busqueda').empty();
            var head = "";
            var body = "";
            var table = "";
            head += '<table class="table"><thead>'+
                '<tr><th>#</th><th>Item</th><th>Categoria</th><th>Opcion</th></tr></thead>'+
                '<tbody>';

            for(var i=0; i<response.length;i++){
                body+='<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response[i].nombre+'</td>' +
                    '<td>'+response[i].tipo_categoria.nombre+'</td>' +
                    '<td><button class="btn btn-sm btn-success-custom" title="Agregar a tabla de items" onclick="agregarItemBuscado('+response[i].id+','+response[i].tipo_categoria.id+')">+</button></td>';
                    '</tr>';
            }

            table=
                head+
                body+
                '</tbody>'+
                '</table>';
            $('#contenido-busqueda').append(table);
            //FALTA AGREGAR
        });
    }else{
        $('#contenido-busqueda').empty();
        $('#contenido-busqueda').append('<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<i class="fa fa-close"></i><strong> Vacio</strong> elemento a buscar se encuentra vacio...'+
            '</div>');
    }

}

function agregarItemBuscado(item, categoria) {
    console.log(item+"-"+categoria);
    var select = $('select[name=tipo_cat_id]');
    if(select.val()==null){ //NO SELECCIONO NINGUNA CATEGORIA
        select.select2({
            allowClear: true,
            placeholder: "Primero seleccione un tipo de pedido...",
            width: '100%'
        }).val(categoria).trigger('change');

        CambiarAgregar(item);

        $('#modalBuscarItem').modal('toggle');
    }else{
        if(select.val()==parseInt(categoria)){ //SE PUEDE ES IGUAL
            CambiarAgregar(item);

            $('#modalBuscarItem').modal('toggle');
        }else{
            alert("No se puede, no es la misma categoria");
        }
    }
    // console.log("sel: "+select);
}

function CambiarAgregar(item) {
    $('select[name^=item_id]').each(function () {

        if($(this).val()==null){
            console.log("cambiar");
            $(this).select2({
                allowClear: true,
                placeholder: "Primero seleccione un tipo de pedido...",
                width: '100%'
            }).val(item).trigger('change');
        }else{
            agregarItemBuscadoListado(item);
            // CambiarAgregar(item);
        }
    });
}

function agregarItemBuscadoListado(item) {
    var tr = "<tr>";
    tr+="<th scope='row'>"+(auxU+1)+"</th>"+
        // "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required>"+options_categorias+"</select></td>"+
        "<td id='td"+auxU+"' data-content='0'><input name='txtItem[]' id='txtItem"+auxU+"' type='text' class='form-control input-hg-12 hidden items-txt text-uppercase' onkeyup='javascript:buscarItem(this.value,"+auxU+");'><select name='item_id[]' id='item_id"+auxU+"' class='items-select2' required onchange='javascript:cambiarUnidad("+auxU+");'>"+options_items+"</select></td>"+
        "<td><input name='cantidad[]' type='number' step='0.1' class='form-control input-hg-12' min='0.1' required></td>"+
        "<td><input name='txtUnidad[]' id='txtUnidad"+auxU+"' class='hidden'/><select name='unidad_id[]' id='unidad_id"+auxU+"' class='js-placeholder-single' required disabled onchange='javascript:cambiarTextoUnidad("+auxU+");'>"+option_unidades+"</select></td>"+
        "<td>" +
        "<a class='editar btnCambiarEditSelect' onclick='javascript:editarCampo("+auxU+");' title='Editar item "+(auxU+1)+"'><i id='i"+auxU+"' class='fa fa-edit'></i></a>" +
        "<a class='eliminar' onclick='javascript:eliminarFila(this);' title='Eliminar item "+(auxU+1)+"'><i class='fa fa-close'></i></a>"+
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
    }).val(item).trigger('change');

    auxU++;
}

function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}