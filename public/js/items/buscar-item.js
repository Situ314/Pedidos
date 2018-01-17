/**
 * Created by djauregui on 8/1/2018.
 */
var items_array = [];
function buscarItem(texto, id_texto) {

    var route = config.rutas[0].buscarItem;
    var token = config.rutas[0].token;

    var items_cargados = config.variables[0].items;
    /*for(var i=0; i<items_cargado.length ;i++){
        console.log(items_cargados[i].nombre);
    }*/
    console.log(items_cargados);
    var result = $.grep(items_cargados, function(e){ return e.id == id; });

    /*$.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        data:{
            nombre: texto
        },
        dataType: 'JSON',
        beforeSend: function (e) {
            $('#alertBuscarNombrePedido').empty();
            $('#alertBuscarNombrePedido').append('<div class="alert alert-info" role="alert">'+
                '<strong><i class="fa fa-search"></i></strong> Buscando...'+
                '</div>');
        }
    }).done(function (response) {
        console.log(response);

        if(response.length > 0){
            $('#alertBuscarNombrePedido').empty();
            console.log(response.length);

            var items_string = "";
            for(var i=0 ; i < response.length ; i++){
                items_string+='<li>'+response[i].nombre+' ('+response[i].tipo_categoria.nombre+') - FILA: '+(parseInt(id_texto)+1)+'</li>';
            }

            items_array[id_texto] = items_string;
            console.log(items_array);

            var items_guardados = "";
            for(var i=0;i<items_array.length;i++){
                items_guardados+=items_array[i];
            }
            $('#alertBuscarNombrePedido').append('<div class="alert alert-danger" role="alert">'+
                '<strong><i class="fa fa-close"></i> Existen los siguientes items: </strong>'+
                    '<ul>' +
                        items_guardados+
                    '</ul>'+
                '</div>');
        }else{
            $('#alertBuscarNombrePedido').empty();
            $('#alertBuscarNombrePedido').append('<div class="alert alert-success" role="alert" style="margin-top: -10px;">'+
                '<strong><i class="fa fa-check"></i></strong> No existen los items descritos en los registros'+
                '</div>');
        }
    }).fail(function (response) {

    });*/
}