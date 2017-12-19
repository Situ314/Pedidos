/**
 * Created by djauregui on 18/12/2017.
 */
$( document ).ready(function() {
    console.log( "main!" );
    getCantidadEstados();
    setInterval(getCantidadEstados, 20000);
});

var arrayCantidades = [];
function getCantidadEstados() {
    var route = configGlobal.rutas[0].getCantidades;
    var token = configGlobal.rutas[0].token;
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        arrayCantidades = [];
        for(var i=0;i<response.length;i++){
            arrayCantidades.push({
                estado: response[i].estado_id,
                cantidad: response[i].cantidad
            });
        }
    });
}