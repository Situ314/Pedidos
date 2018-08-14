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
                '<tr><th>#</th><th>Item</th><th>Categoria</th></tr></thead>'+
                '<tbody>';

            for(var i=0; i<response.length;i++){
                body+='<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response[i].nombre+'</td>' +
                    '<td>'+response[i].tipo_categoria.nombre+'</td>' +
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

function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}