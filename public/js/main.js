/**
 * Created by djauregui on 18/12/2017.
 */
$( document ).ready(function() {
    getCantidadEstadosAu();
    getCantidadEstados();
    setInterval(getCantidadEstados, 20000);
    setInterval(getCantidadEstadosAu, 20000);
});

var arrayCantidades = [];
function getCantidadEstados() {
    var route = configGlobal.rutas[0].getCantidades;
    var token = configGlobal.rutas[0].token;

    // console.log("Cantidad global");
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        console.log(response);
        arrayCantidades = [];
        for(var i=0;i<response.length;i++){
            arrayCantidades.push({
                estado: response[i].estado_id,
                cantidad: response[i].cantidad
            });
        }
    });
}

var arrayCantidadesAu = [];
function getCantidadEstadosAu() {
    var route = configGlobal.rutas[0].getCantidadesAu;
    var token = configGlobal.rutas[0].token;

     console.log("Cantidad global AU");

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'JSON',
        beforeSend: function(e){
        }
    }).done(function (response){
        console.log(response);
        arrayCantidadesAu = [];
        for(var i=0;i<response.length;i++){
            arrayCantidadesAu.push({
                estado: response[i].estado_id,
                cantidad: response[i].cantidad
            });
        }
    });
}

function misAutorizadores() {
    var ruta = configGlobal.rutas[0].postAutorizadores;
    var token = configGlobal.rutas[0].token;

    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        method: 'POST',
        dataType: 'JSON',
        beforeSend: function(e){

        }
    }).done(function (response){
        console.log(response);
        $('#bodyModalAutorizadores').empty();
        $('#bodyModalAutorizadores').append(response);

        $('#modalAutorizadores').modal('show');
    }).fail(function (response){

    });
}