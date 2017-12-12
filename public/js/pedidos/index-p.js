/**
 * Created by djauregui on 8/12/2017.
 */

var usuarios = "";
$( document ).ready(function(){

    getRealizado();

    getCantidadEstados();
});

$('ul#myTab li a').click(function (e) {
    console.log(this.id);
    console.log(this.id.split('-tab'));
    var estado = this.id.split('-tab')[0];

    var route = rutas.pedidos;
    var token = rutas.token;

    $.ajax({
     url: route,
     headers: {'X-CSRF-TOKEN': token},
     type: 'POST',
     data:{
         estado_id: estado
     },
     dataType: 'JSON',
     beforeSend: function(e){
         $('#contenido-tab').empty();
         $('#contenido-tab').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
             '<i class="fa fa-spin fa-spinner"></i><strong> Cargando</strong> pedidos...'+
             '</div>');
     }
     }).done(function (response){
        var body = "";
        if(response.length!=0){
            for(var i=0;i<response.length;i++){
                var opciones = '';
                if(estado==1){
                    opciones ='<td>' +
                        '<div class="btn-group" role="group">' +
                        '<button type="button" class="btn btn-secondary" title="Ver lista '+response[i].codigo+'" onclick="javascript:verItems('+response[i].id+');"><i class="fa fa-sort-amount-desc"></i></button>' +
                        '<button type="button" class="btn btn-secondary" title="Asignar responsable" onclick="javascript:asignarResponsable('+response[i].id+');"><i class="fa fa-mail-forward"></i></button>' +
                        '</div></td>';
                }else{
                    opciones ='<td>' +
                        '<div class="btn-group" role="group">' +
                        '<button type="button" class="btn btn-secondary" title="Ver lista '+response[i].codigo+'" onclick="javascript:verItems('+response[i].id+');"><i class="fa fa-sort-amount-desc"></i></button>' +
                        '</div></td>';
                }
                body+='<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response[i].codigo+'</td>' +
                    '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                    '<td>'+response[i].proyecto.nombre+'</td>' +
                    opciones +
                    '</tr>';
            }

            body='<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Opciones</th></tr></thead>'+
                '<tbody>'+
                body+
                '</tbody>'+
                '</table>';
        }else{
            body += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
            '</div>';
        }

        $('#contenido-tab').empty();
        $('#contenido-tab').append(body);
     });
});

function getRealizado() {
    var route = rutas.pedidos;
    var token = rutas.token;

    console.log(route);
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        data:{
            estado_id: 1
        },
        dataType: 'JSON',
        beforeSend: function(e){
            $('#contenido-tab').empty();
            $('#contenido-tab').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                                        '<i class="fa fa-spin fa-spinner"></i><strong> Cargando</strong> pedidos...'+
                                        '</div>');
        }
    }).done(function (response){
        $('#contenido-tab').empty();
        var body = "";
        for(var i=0;i<response.length;i++){
            body+='<tr><th scope="row">'+(i+1)+'</th>' +
                '<td>'+response[i].codigo+'</td>' +
                '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                '<td>'+response[i].proyecto.nombre+'</td>' +
                '<td><div class="btn-group" role="group"><button type="button" class="btn btn-secondary" title="Ver lista '+response[i].codigo+'" onclick="javascript:verItems('+response[i].id+');"><i class="fa fa-sort-amount-desc"></i></button><button type="button" class="btn btn-secondary" title="Asignar responsable" onclick="javascript:asignarResponsable('+response[i].id+');"><i class="fa fa-mail-forward"></i></button></div></td>'+
                '</tr>';
        }

        $('#contenido-tab').append(
            '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Opciones</th></tr></thead>'+
                '<tbody>'+
                body+
                '</tbody>'+
            '</table>');
    });
}

function getCantidadEstados() {

}

function verItems(id) {
    var route = rutas.getPedido;
    var token = rutas.token;

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        data:{
            id: id
        },
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        var tableItems='';
        if(response.items_pedido.length!=0){
            var bodyItems = '';
            for(var i=0;i<response.items_pedido.length;i++){
                console.log(response.items_pedido[i]);

                bodyItems += '<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response.items_pedido[i].item.nombre+'</td>' +
                    '<td>'+response.items_pedido[i].cantidad+'</td>' +
                    '<td>'+response.items_pedido[i].item.unidad.nombre+' ('+response.items_pedido[i].item.unidad.descripcion+')</td></tr>';
            }
            tableItems = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Unidad</th></tr></thead>' +
                '<tbody>' +
                    bodyItems+
                '</tbody>'+
                '</table>';
        }else {
            tableItems = '<p>No hay items en el listado</p>'
        }

        $('#panel-body-items').empty();
        $('#panel-body-items').append(tableItems);

        var tableItemsTemp='';
        console.log("temp: "+response.items_temp_pedido.length);

        if(response.items_temp_pedido.length!=0){
            var bodyItemsTemp = '';
            for(var i=0;i<response.items_temp_pedido.length;i++){
                bodyItemsTemp += '<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response.items_temp_pedido[i].item.nombre+'</td>' +
                    '<td>'+response.items_temp_pedido[i].cantidad+'</td>' +
                    '<td>'+response.items_temp_pedido[i].item.unidad.nombre+' ('+response.items_temp_pedido[i].item.unidad.descripcion+')</td></tr>';
            }
            tableItemsTemp = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Unidad</th></tr></thead>' +
                '<tbody>' +
                bodyItemsTemp+
                '</tbody>'+
                '</table>';
        }else{
            tableItemsTemp = '<p>No hay items a verificar en el listado</p>'
        }

        $('#panel-body-items-temp').empty();
        $('#panel-body-items-temp').append(tableItemsTemp);

        // $('#bodyPedido').empty();
        // $('#bodyPedido').append(tableItems);
        $('#verPedidoModal').modal('show');

    });

}

function asignarResponsable(id) {
    console.log(id);
}