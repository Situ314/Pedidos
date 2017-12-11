/**
 * Created by djauregui on 8/12/2017.
 */
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

    console.log(route);
    $.ajax({
     url: route,
     headers: {'X-CSRF-TOKEN': token},
     type: 'POST',
     data:{
         estado_id: estado
     },
     dataType: 'JSON',
     beforeSend: function(e){

     }
     }).done(function (response){
         console.log(response);
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
        $('#contenido-tab').append('<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th></tr></thead>'+
                                '<tbody>'+
                                '<tr>'+
                                '<th scope="row">1</th>'+
                                    '<td>a</td>'+
                                    '<td>Otto</td>'+
                                    '<td>@mdo</td>'+
                                '</tr>'+
                                '</tbody>'+
                                '</table>');
        console.log(response);
    });
}
function getCantidadEstados() {

}