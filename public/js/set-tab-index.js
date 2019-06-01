/**
 * Created by djauregui on 17/1/2018.
 */
var arrayCantidadesLocal = [];
function setTabsCantidad() {
    /*console.log("Local");
    console.log(arrayCantidadesLocal);
    console.log("Global");
    console.log(arrayCantidades);*/

    if(arrayCantidades.length != arrayCantidadesLocal.length){
        // console.log("es distinto");
        arrayCantidadesLocal = arrayCantidades;
        getTabla();
        resetTabs();
    }else{
        for(var i=0; i<arrayCantidadesLocal.length ;i++){
            // console.log(arrayCantidadesLocal[i].estado);
            // console.log(arrayCantidades[i].estado);
            if(arrayCantidadesLocal[i].estado != arrayCantidades[i].estado){
                // console.log("distinto en objetos");
            }else{
                // console.log(arrayCantidadesLocal[i].cantidad);
                // console.log(arrayCantidades[i].cantidad);
                if(arrayCantidadesLocal[i].cantidad != arrayCantidades[i].cantidad){
                    // console.log("distinto en cantidad");
                    arrayCantidadesLocal = arrayCantidades;

                    getTabla();
                    resetTabs();
                // }else{
                //     console.log("igual en cantidad");
                }
            }
        }
    }
}

function setTabsCantidadAu() {
    /*console.log("Local");
    console.log(arrayCantidadesLocal);
    console.log("Global");
    console.log(arrayCantidades);*/
    var pathname = window.location.pathname;

    console.log(pathname);
    console.log(arrayCantidadesAu);
    if(arrayCantidadesAu.length != arrayCantidadesLocal.length){
        // console.log("es distinto");
        arrayCantidadesLocal = arrayCantidadesAu;

        getTabla();
        resetTabsAu();
    }else{
        for(var i=0; i<arrayCantidadesLocal.length ;i++){
            // console.log(arrayCantidadesLocal[i].estado);
            // console.log(arrayCantidades[i].estado);
            if(arrayCantidadesLocal[i].estado != arrayCantidadesAu[i].estado){
                // console.log("distinto en objetos");
            }else{
                // console.log(arrayCantidadesLocal[i].cantidad);
                // console.log(arrayCantidades[i].cantidad);
                if(arrayCantidadesLocal[i].cantidad != arrayCantidadesAu[i].cantidad){
                    // console.log("distinto en cantidad");
                    arrayCantidadesLocal = arrayCantidadesAu;

                    getTabla();
                    resetTabsAu();
                    // }else{
                    //     console.log("igual en cantidad");
                }
            }
        }
    }
}

function resetTabs() {
    for(var i=0 ; i<$('#myTab').children().length-1 ; i++){
        // console.log(  $($('#myTab').children()[i]).children().children().prop('id') );
        $($('#myTab').children()[i]).children().children().text(0);
    }

    for(var i=0;i<arrayCantidades.length;i++){
        $('#'+arrayCantidades[i].estado+'-tab-cantidad').text(arrayCantidades[i].cantidad);
    }
}


function resetTabsAu() {
    for(var i=0 ; i<$('#myTab').children().length-1 ; i++){
        // console.log(  $($('#myTab').children()[i]).children().children().prop('id') );
        $($('#myTab').children()[i]).children().children().text(0);
    }

    for(var i=0;i<arrayCantidadesAu.length;i++){
        $('#'+arrayCantidadesAu[i].estado+'-tab-cantidad').text(arrayCantidadesAu[i].cantidad);
    }
}