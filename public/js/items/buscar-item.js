/**
 * Created by djauregui on 8/1/2018.
 */
// []
// A $( document ).ready() block.
function buscarItem(texto) {

    var route = config.rutas[0].buscarItem;
    var token = config.rutas[0].token;


    $.ajax({
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
        if(response.length > 0){
            $('#alertBuscarNombrePedido').empty();
            var items = '';
            for(var i=0 ; i < response ; i++){
                items+='<li>'+response[i].nombre+'</li>';
            }
            $('#alertBuscarNombrePedido').append('<div class="alert alert-danger" role="alert">'+
                '<strong><i class="fa fa-close"></i></strong>'+
                    '<ul>' +
                        items+
                    '</ul>'+
                '</div>');
        }else{
            $('#alertBuscarNombrePedido').empty();
            $('#alertBuscarNombrePedido').append('<div class="alert alert-success" role="alert">'+
                '<strong><i class="fa fa-check"></i></strong> No existen los items descritos en los registros'+
                '</div>');
        }
    }).fail(function (response) {

    });
}