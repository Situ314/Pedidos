/**
 * Created by djauregui on 9/2/2018.
 */
$( document ).ready(function(){
    setInterval(setTabsCantidad, 5000);
    var arrayMeses = [
        "Vacio",
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    ];

    var inicio = arrayMeses[moment().format("M")]+' '+moment().format("D")+', '+moment().format("YYYY");
    var fin = arrayMeses[moment().format("M")]+' '+moment().format("D")+', '+moment().format("YYYY");

    $('#dateRange span').html(inicio + ' - ' + fin);

    console.log(myChart.data);

});

var arrayCantidadesLocal = [];
function setTabsCantidad() {
    /*console.log("Local");
     console.log(arrayCantidadesLocal);
     console.log("Global");
     console.log(arrayCantidades);*/

    if(arrayCantidades.length != arrayCantidadesLocal.length){
        // console.log("es distinto");
        arrayCantidadesLocal = arrayCantidades;

        resetDivs();
        setDivs();
    }else{
        for(var i=0; i<arrayCantidadesLocal.length ;i++){
            // console.log(arrayCantidadesLocal[i].estado);
            // console.log(arrayCantidades[i].estado);
            if(arrayCantidadesLocal[i].estado != arrayCantidades[i].estado){
                // console.log("distinto en objetos");
                resetDivs();
                setDivs();
            }else{
                // console.log(arrayCantidades[i].cantidad);
                if(arrayCantidadesLocal[i].cantidad != arrayCantidades[i].cantidad){
                    // console.log("distinto en cantidad");
                    arrayCantidadesLocal = arrayCantidades;

                    resetDivs();
                    setDivs();
                }
            }
        }
    }
}

//RESETEA LOS VALORES DE LOS DIVS
function resetDivs() {
    $('[id^="div-estado-"]').text(0);
}

//SETEA LOS VALORES
function setDivs() {
    var aux = 0;
    for(var i=0; i<arrayCantidadesLocal.length ;i++){
        $('#div-estado-'+arrayCantidadesLocal[i].estado).text( arrayCantidadesLocal[i].cantidad );
        aux += arrayCantidadesLocal[i].cantidad;
    }

    //DIV TOTAL
    $('#div-estado-0').text( aux );
}

//ACTUALIZANDO EL CHART
function addData(chart, label, data) {
    chart.data.labels.push(label);
    chart.data.datasets.forEach(function(dataset){
        dataset.data.push(data);
    });
    chart.update();
}

function removeData(chart) {

    console.log(chart.data);
    console.log(chart.data.datasets.length);
    var tamaño = chart.data.datasets.length;
    for(var i=0 ; i<tamaño ; i++){
        // console.log("Eliminando: "+i);
        chart.data.datasets.pop(0);
    }
    /*var aux = 1;
    chart.data.datasets.forEach(function(dataset){
        dataset.data.pop();
        console.log("Iteracion: "+aux);
        console.log(dataset.data);
        aux++;
    });*/
    chart.update();
}

function getChartUpdate(fecha_inicio, fecha_fin) {
    console.log(fecha_inicio+" "+fecha_fin);
    removeData(myChart);

}