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

function resetTabs() {
    console.log($('#myTab').children());

    for(var i=0 ; i<$('#myTab').children().length ; i++){
        // console.log(  $($('#myTab').children()[i]).children().children().prop('id') );
        $($('#myTab').children()[i]).children().children().text(0);
    }

    for(var i=0;i<arrayCantidades.length;i++){
        $('#'+arrayCantidades[i].estado+'-tab-cantidad').text(arrayCantidades[i].cantidad);
    }
}