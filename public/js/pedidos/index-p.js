/**
 * Created by djauregui on 8/12/2017.
 */
var verificacion = "";
var verifiAut = "";
$( document ).ready(function(){
    $(".js-placeholder-single").select2({
        allowClear: true,
        placeholder: "Seleccione ...",
        width: '100%'
    }).val('0').trigger('change');

    //Agregando rutas como variables clobales
    verificacion = rutas.verificacion.replace(":id","");
    verifiAut = rutas.verificacionAutorizador.replace(":id","");
    getTabla();

    setInterval(setTabsCantidad, 5000);
});

$('#modalDocumentos').on('hidden.bs.modal', function () {
    // do something…
    $('#filepdf').hide();
});

$('.js-placeholder-single').select2({
    allowClear: true,
    placeholder: "Seleccione...",
    width: '100%'
}).val('').trigger('change');

$('ul#myTab li a').click(function (e) {
    var estado = this.id.split('-tab')[0];
    console.log("ESTADO==>"+ estado);
    var route = rutas.pedidos;
    var token = rutas.token;

    if(estado=="busqueda"){

        $('#contenido-tab').empty();
        $('#contenido-tab').append('<div class="input-group col-md-12"><div class="col-md-3">' +
            '<select id="selectTipo" class="form-control js-placeholder-single">' +
            // '<option value="" disabled selected>Seleccione tipo de búsqueda...</option>'+
            '<option value="columnas" selected="selected">BÚSQUEDA POR COLUMNAS</option>' +
            '<option value="item">BÚSQUEDA POR ITEMS</option>' +
            '</select>'+
            '</div>' +
            '<div class="col-md-9">' +
            '<div class="input-group">' +
            '<input id="txtBuscarPedido" style="height: 34px !important;" type="text" class="form-control" placeholder=" Buscar...">'+
            '<span class="input-group-btn">' +
            '<button class="btn btn-default" type="button" onclick="tipoBusqueda();"><i class="fa fa-search"></i></button>' +
            '</span>'+
            '</div>' +
            '</div></div>');

        $('.js-placeholder-single').select2({
            allowClear: true,
            placeholder: "Seleccione...",
            width: '100%'
        }).val('').trigger('change');
    }else{
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
            actualizarTabla(response, estado);
        });
    }
});

function getTabla() {
    var route = rutas.pedidos;
    var token = rutas.token;

    var estado = null;
    for(var i=0 ; i < $('#myTab').children().length-1 ; i++){
        if( $($('#myTab').children()[i]).hasClass("active") ){
            estado = $($('#myTab').children()[i]).children().children().prop('id').split('-tab-cantidad')[0];
        }
    }

    if(estado!=null){
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

            actualizarTabla(response, estado);
        });
    }
}

function actualizarTabla(response, estado) {
    console.log("ESTADO-->",estado);
    console.log("JSON--->", response);
    var head = "";
    var body = "";
    var table = "";
    if(response.length!=0){
        switch ( parseInt(variables.uR)){
            case 1://R
            case 2://AD
            case 3://AS
            case 4://RE
            case 5://AU
            case 8://REVISOR AF
            case 9://WATCHER
            case 10: //REVISOR TIC
            case 11: //RESPONSABLE TIC
                if(estado == 4 || estado == 5|| estado ==8)
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>#' +
                        '</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                else
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo' +
                        '</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                break;
            case 6://US
            case 7://R.ENT.
                if(estado == 4 || estado == 5|| estado ==8)
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>#</th><th>Empresa</th><th>Proyecto</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                else
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';

                break;
        }


        for(var i=0;i<response.length;i++){
            switch (parseInt(variables.uR)){
                case 1://R
                case 2://AD
                case 9://WATCHER
                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    var padre = response[i].proyecto_empresa.nombre;
                    if(response[i].proyecto_empresa.padre != null){
                        padre = response[i].proyecto_empresa.padre.nombre+" &#10148 "+response[i].proyecto_empresa.nombre;
                    }
                    if(estado == 4 || estado == 5|| estado ==8){

                        if(response[i].salidas_almacen_tic[0] != null)
                            salida = 'TICS #' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;

                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+salida+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response [i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response [i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    //************************************
                    break;
                case 3://AS

                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[i].id)+'" title="Asignar pedido '+response[i].codigo+'" onclick="asignarPedido('+response[i].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[i].id)+'" title="Asignar pedido '+response[i].codigo+'" onclick="asignarPedido('+response[i].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;

                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    var padre = response[i].proyecto_empresa.nombre;
                    if(response[i].proyecto_empresa.padre != null){
                        padre = response[i].proyecto_empresa.padre.nombre+" &#10148 "+response[i].proyecto_empresa.nombre;
                    }
                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                        '<td>'+padre+'</td>' +
                        '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                        '<td>'+responsable+'</td>' +
                        '<td>'+response [i].created_at+'</td>' +
                        '<td><div class="btn-group" role="group">' +
                        opciones+
                        '</div></td>'+
                        '</tr>';
                    //************************************
                    break;
                case 4://RE

                    //************************************ASIGNADO
                    var bool_asignado_opciones = false;
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].id==variables.uI)
                                bool_asignado_opciones = true;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';
                        }
                    }
                    //************************************

                    //************************************OPCIONES
                    var opciones = "";

                    switch (parseInt(estado)){
                        case 1:
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';

                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 4:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[i].id+', 4);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 5:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[i].id+', 5);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 6:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 7:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 9:
                            if(bool_asignado_opciones){
                                var penultimo_estado =  response[i].estados_pedido[response[i].estados_pedido.length-2].estado_id;
                                for(var k=response[i].estados_pedido.length-1;k>0;k--){
                                    if(response[i].estados_pedido[k].estado_id!=9){
                                        penultimo_estado = response[i].estados_pedido[k].estado_id;
                                        break;
                                    }
                                }
                                switch (parseInt(penultimo_estado)){
                                    case 3: //PENULTIMO ESTADO - ASIGNADO
                                        opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                            '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                        break;
                                    case 4: //PENULTIMO ESTADO - PARCIAL
                                        opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                            '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[i].id+', 4);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                            '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                        break;
                                }
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var padre = response[i].proyecto_empresa.nombre;
                    if(response[i].proyecto_empresa.padre != null){
                        padre = response[i].proyecto_empresa.padre.nombre+" &#10148 "+response[i].proyecto_empresa.nombre;
                    }
                    if(estado == 4 || estado == 5|| estado ==8){

                        if(response[i].salidas_almacen_tic[0] != null)
                            salida = 'TICs # ' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;

                       body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+salida+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    //************************************

                    break;
                case 5://AU

                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 2:
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>';
                            if(variables.uI==response[i].solicitante_id){
                                opciones+='<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                            }
                            opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    //************************************CUERPO
                    var proyecto = "SIN PROYECTO";
                    var empresa = "SIN EMPRESA";
                    if(response[i].proyecto_empresa!=null){
                        proyecto = response[i].proyecto_empresa.nombre;
                        empresa = response[i].proyecto_empresa.empresa.nombre
                    }

                    if(estado == 4 || estado == 5|| estado ==8){
                        if(response[i].salidas_almacen_tic[0] != null)
                            salida = 'TIC #' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;
                       body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+salida+'</td>' +
                            '<td>'+proyecto+'</td>' +
                            '<td>'+empresa+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+proyecto+'</td>' +
                            '<td>'+empresa+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';


                    //************************************
                    break;
                case 6://US
                case 7://R.ENT.

                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                        case 2:
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    //************************************CUERPO
                    console.log('OPCIONES'+opciones);
                    if(estado == 4 || estado == 5|| estado ==8) {
                        if (response[i].salidas_almacen_tic[0] != null)
                            salida = 'TIC # ' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;

                        body += '<tr><th scope="row">' + (i + 1) + '</th>' +
                            '<td>' + response[i].codigo + '</td>' +
                            '<td>' + salida + '</td>' +
                            '<td>' + response[i].proyecto_empresa.empresa.nombre + '</td>' +
                            '<td>' + response[i].proyecto_empresa.nombre + '</td>' +
                            '<td>' + responsable + '</td>' +
                            '<td>' + response[i].created_at + '</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones +
                            '</div></td>' +
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';


                    //************************************
                    break;
                case 8://REVISOR AF

                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[i].id)+'" title="Verificar Activos Fijos de pedido '+response[i].codigo+'"><i class="fa fa-tags"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>';
                            if(variables.uI==response[i].solicitante_id){
                                opciones+='<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                            }
                            opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(response[i].tipo_categoria_id == '20')
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            else
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[i].id)+'" title="Verificar Activos Fijos de pedido '+response[i].codigo+'"><i class="fa fa-tags"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    //************************************CUERPO
                    var proyecto = "SIN PROYECTO";
                    var empresa = "SIN EMPRESA";
                    if(response[i].proyecto_empresa!=null){
                        proyecto = response[i].proyecto_empresa.nombre;
                        empresa = response[i].proyecto_empresa.empresa.nombre
                    }

                    if(estado == 4 || estado == 5|| estado ==8) {

                        if (response[i].salidas_almacen_tic[0] != null)
                            salida = response[i].salidas_almacen_tic[0].num_solicitud;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;

                        body += '<tr><th scope="row">' + (i + 1) + '</th>' +
                            '<td>' + response[i].codigo + '</td>' +
                            '<td>' + salida + '</td>' +
                            '<td>' + proyecto + '</td>' +
                            '<td>' + empresa + '</td>' +
                            '<td>' + response[i].solicitante_empleado.empleado.nombres + ' ' + response[i].solicitante_empleado.empleado.apellido_1 + ' ' + response[i].solicitante_empleado.empleado.apellido_2 + '</td>' +
                            '<td>' + responsable + '</td>' +
                            '<td>' + response[i].created_at + '</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones +
                            '</div></td>' +
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+proyecto+'</td>' +
                            '<td>'+empresa+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';


                    //************************************
                    break;
                case 10://REVISOR TICSZ

                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.asignadorTicEdit.replace(":id",response[i].id)+'" title="Asignar pedido '+response[i].codigo+'" onclick="asignarPedido('+response[i].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                        case 5:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 6:
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[i].id)+'" title="Asignar pedido '+response[i].codigo+'" onclick="asignarPedido('+response[i].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;

                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                        }
                    }
                    var padre = response[i].proyecto_empresa.nombre;
                    if(response[i].proyecto_empresa.padre != null){
                        padre = response[i].proyecto_empresa.padre.nombre+" &#10148 "+response[i].proyecto_empresa.nombre;
                    }
                    if(estado == 4 || estado == 5|| estado ==8) {
                        if (response[i].salidas_almacen_tic[0] != null)
                            salida = 'TIC # ' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;

                        body += '<tr><th scope="row">' + (i + 1) + '</th>' +
                            '<td>' + response[i].codigo + '</td>' +
                            '<td>' + salida + '</td>' +
                            '<td>' + response[i].proyecto_empresa.empresa.nombre + '</td>' +
                            '<td>' + response[i].proyecto_empresa.nombre + '</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>' + responsable + '</td>' +
                            '<td>' + response[i].created_at + '</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones +
                            '</div></td>' +
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response [i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    //************************************
                    break;
                case 11://RESPONSABLE TICS

                    //************************************ASIGNADO
                    var bool_asignado_opciones = false;
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                        for(var j=0;j<response[i].asignados_nombres.length;j++){
                            responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                            if(response[i].asignados_nombres[j].id==variables.uI)
                                bool_asignado_opciones = true;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';
                        }
                    }
                    //************************************

                    //************************************OPCIONES
                    var opciones = "";

                    switch (parseInt(estado)){
                        case 1:
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<a class="btn btn-primary-custom" target="_blank" href="'+rutas.imprimirTic.replace(':id',response[i].id)+'" title="Imprimir pedido '+response[i].codigo+'"><i class="fa fa-print"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';

                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 4:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasTic('+response[i].id+', 4);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<a class="btn btn-primary-custom" target="_blank" href="'+rutas.imprimirTic.replace(':id',response[i].id)+'" title="Imprimir pedido '+response[i].codigo+'"><i class="fa fa-print"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 5:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-primary-custom" target="_blank" href="'+rutas.imprimirTic.replace(':id',response[i].id)+'" title="Imprimir pedido '+response[i].codigo+'"><i class="fa fa-print"></i></a>'+
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasTic('+response[i].id+', 5);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 6:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 7:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 8:
                            if(bool_asignado_opciones){
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-primary-custom" target="_blank" href="'+rutas.imprimirTic.replace(':id',response[i].id)+'" title="Imprimir pedido '+response[i].codigo+'"><i class="fa fa-print"></i></a>'+
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 9:
                            if(bool_asignado_opciones){
                                var penultimo_estado =  response[i].estados_pedido[response[i].estados_pedido.length-2].estado_id;
                                for(var k=response[i].estados_pedido.length-1;k>0;k--){
                                    if(response[i].estados_pedido[k].estado_id!=9){
                                        penultimo_estado = response[i].estados_pedido[k].estado_id;
                                        break;
                                    }
                                }
                                switch (parseInt(penultimo_estado)){
                                    case 3: //PENULTIMO ESTADO - ASIGNADO
                                        opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                            '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                        break;
                                    case 4: //PENULTIMO ESTADO - PARCIAL
                                        opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                            '<button type="button" class="btn btn-warning-custom" onclick="verSalidasTic('+response[i].id+', 4);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                            '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                        break;
                                }
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                        case 10:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 11:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var padre = response[i].proyecto_empresa.nombre;
                    if(response[i].proyecto_empresa.padre != null){
                        padre = response[i].proyecto_empresa.padre.nombre+" &#10148 "+response[i].proyecto_empresa.nombre;
                    }
                    var salida = "";


                    if(estado == 4 || estado == 5|| estado ==8){
                        if(response[i].salidas_almacen_tic[0] != null)
                            salida = 'TIC # ' + response[i].salidas_almacen_tic[0].num_ticket;
                        else
                            salida = response[i].salidas_almacen[0].num_solicitud;
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+salida+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    }
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+padre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    //************************************

                    break;
            }
        }

        table=
            head+
            body+
            '</tbody>'+
            '</table>';
    }else{
        if(estado!=""){
            table += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
                '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
                '</div>';
        }

    }

    $('#contenido-tab').empty();
    $('#contenido-tab').append(table);
}

function verItems(id) {
    var route = rutas.getItem;
    var token = rutas.token;

    var imp_sol = rutas.impSol;
    var imp_ent = rutas.impEnt;
    var imp_tic= rutas.imprimirTic;
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
        console.log(response);
        console.log(variables.uR);
        var tableItems='';
        var contItemsPedidos = 1;
        if(response.items_pedido.length>0 || response.items_temp_pedido.length>0){

            var bodyItems = '';
            for(var i=0;i<response.items_temp_pedido.length;i++){

                if(variables.uR == '3' || variables.uR == '4' ||variables.uR == '8' ){
                    var stock = '<label class="label label-info">NO REQUIERE</label>';
                    if(response.items_temp_pedido[i].control_stock.length >0)
                        stock=response.items_temp_pedido[i].control_stock[0].stock;

                    var tipo_compra = '<label class="label label-info">S/R</label>';
                    if(response.items_temp_pedido[i].tipo_compra != null){
                        if(response.items_temp_pedido[i].tipo_compra.id == '3')
                            tipo_compra = '<label class="label label-default">'+response.items_temp_pedido[i].tipo_compra.nombre+'</label>';
                        else
                            tipo_compra = '<label class="label label-primary">'+response.items_temp_pedido[i].tipo_compra.nombre+'</label>';
                    }

                    bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                        '<td>'+response.items_temp_pedido[i].item.nombre+'</td>' +
                        '<td>'+response.items_temp_pedido[i].cantidad+'</td>' +
                        '<td>'+stock+'</td>' +
                        '<td>'+response.items_temp_pedido[i].item.unidad.nombre+' ('+response.items_temp_pedido[i].item.unidad.descripcion+')</td>' +
                        '<td>'+tipo_compra+'</td>'+
                        '<td><label class="label label-warning">Item Temporal</label></tr>';
                }else{
                    var tipo_compra = '<label class="label label-info">S/R</label>';
                    if(response.items_temp_pedido[i].tipo_compra != null){
                        if(response.items_temp_pedido[i].tipo_compra.id == '3')
                            tipo_compra = '<label class="label label-default">'+response.items_temp_pedido[i].tipo_compra.nombre+'</label>';
                        else
                            tipo_compra = '<label class="label label-primary">'+response.items_temp_pedido[i].tipo_compra.nombre+'</label>';
                    }

                    bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                        '<td>'+response.items_temp_pedido[i].item.nombre+'</td>' +
                        '<td>'+response.items_temp_pedido[i].cantidad+'</td>' +
                        '<td>'+response.items_temp_pedido[i].item.unidad.nombre+' ('+response.items_temp_pedido[i].item.unidad.descripcion+')</td>'+
                        '<td>'+tipo_compra+'</td>'+
                        '<td><label class="label label-warning  ">Item Temporal</label></tr>';
                }


                contItemsPedidos++;

                // var stock = '';
                // if(response.items_temp_pedido[i].control_stock.length >0)
                //     stock=response.items_temp_pedido[i].control_stock.stock;
                //
                // bodyItems += '<td><th scope="row">'+contItemsPedidos+'</th>' +
                //     '<td>'+response.items_temp_pedido[i].item.nombre+'</td>' +
                //     '<td>'+response.items_temp_pedido[i].cantidad+'</td>' +
                //     '<td>'+stock+'</td>' +
                //     '<td>'+response.items_temp_pedido[i].item.unidad.nombre+' ('+response.items_temp_pedido[i].item.unidad.descripcion+')</td>' +
                //     '<td><label class="label label-warning">Item Temporal</label></td>'+
                //     '<td><label class="label label-default">'+response.items_temp_pedido[i].nombre+'</label></td>';
                //
                // contItemsPedidos++;
            }
            for(var i=0;i<response.items_pedido.length;i++){
                if(variables.uR == '3' || variables.uR == '4' ||variables.uR == '8' ){
                    var stock = '<label class="label label-info">NO REQUIERE</label>';
                    if(response.items_pedido[i].control_stock.length >0)
                        stock=response.items_pedido[i].control_stock[0].stock;

                    var tipo_compra = '<label class="label label-info">S/R</label>';
                    // if(response.items_pedido[i].tipo_compra != null)
                    //     var tipo_compra = '<label class="label label-default">'+response.items_pedido[i].tipo_compra.nombre+'</label>';
                    if(response.items_pedido[i].tipo_compra != null){
                        if(response.items_pedido[i].tipo_compra.id == '3')
                            tipo_compra = '<label class="label label-default">'+response.items_pedido[i].tipo_compra.nombre+'</label>';
                        else
                            tipo_compra = '<label class="label label-primary">'+response.items_pedido[i].tipo_compra.nombre+'</label>';
                    }

                    bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                        '<td>'+response.items_pedido[i].item.nombre+'</td>' +
                        '<td>'+response.items_pedido[i].cantidad+'</td>' +
                        '<td>'+stock+'</td>' +
                        '<td>'+response.items_pedido[i].item.unidad.nombre+' ('+response.items_pedido[i].item.unidad.descripcion+')</td>'+
                        '<td>'+tipo_compra+'</td>'+
                        '<td><label class="label label-success">Item Registrado</label></tr>';
                }else{
                    var tipo_compra = '<label class="label label-info">S/R</label>';
                    if(response.items_pedido[i].tipo_compra != null){
                        if(response.items_pedido[i].tipo_compra.id == '3')
                            tipo_compra = '<label class="label label-default">'+response.items_pedido[i].tipo_compra.nombre+'</label>';
                        else
                            tipo_compra = '<label class="label label-primary">'+response.items_pedido[i].tipo_compra.nombre+'</label>';
                    }

                    bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                        '<td>'+response.items_pedido[i].item.nombre+'</td>' +
                        '<td>'+response.items_pedido[i].cantidad+'</td>' +
                        '<td>'+response.items_pedido[i].item.unidad.nombre+' ('+response.items_pedido[i].item.unidad.descripcion+')</td>'+
                        '<td>'+tipo_compra+'</td>'+
                        '<td><label class="label label-success">Item Registrado</label></tr>';
                }

                contItemsPedidos++;
            }
            if(variables.uR == '3' || variables.uR == '4' ||variables.uR == '8' ){
                tableItems = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Stock</th><th>Unidad</th><th>Tipo</th><th>Tipo de Compra</th></tr></thead>' +
                    '<tbody>' +
                    bodyItems+
                    '</tbody>'+
                    '</table>';
            }else{
                tableItems = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Unidad</th><th>Tipo</th><th>Tipo de Compra</th></tr></thead>' +
                    '<tbody>' +
                    bodyItems+
                    '</tbody>'+
                    '</table>';
            }


        }else {
            tableItems = '<p>No hay items en el listado</p>'
        }

        $('#panel-body-items').empty();
        $('#panel-body-items').append(tableItems);

        var tableItemsEntregado='';

        if(response.items_entrega.length!=0){
            $('#btnImprimirItemsEntregar').show();
            var bodyItemsEntregar = '';

            for(var i=0;i<response.items_entrega.length;i++){
                var entregado = 0;
                for(var j=0;j<response.salidas_almacen.length;j++){
                    for(var k=0;k<response.salidas_almacen[j].salida_items.length;k++){
                        if(response.salidas_almacen[j].salida_items[k].item_pedido_entregado.item_id == response.items_entrega[i].item.id){
                            entregado=entregado+response.salidas_almacen[j].salida_items[k].cantidad;
                        }
                    }
                }

                var labelEntregado = '';
                if(Number(entregado) >= response.items_entrega[i].cantidad)
                    labelEntregado = '<label class="label label-success">Completo</label>';
                else{
                    if(Number(entregado) == 0)
                        labelEntregado = '<label class="label label-danger">Sin Entrega</label>';
                    else
                        labelEntregado = '<label class="label label-warning">Parcial</label>';
                }

                bodyItemsEntregar += '<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response.items_entrega[i].item.nombre+'</td>' +
                    '<td>'+response.items_entrega[i].cantidad+'</td>' +
                    '<td>'+labelEntregado+' '+parseFloat(entregado).toFixed(2)+'</td>' +
                    '<td>'+response.items_entrega[i].item.unidad.nombre+' ('+response.items_entrega[i].item.unidad.descripcion+')</td>'+
                    '<td><label class="label label-success">Item Registrado</label></tr>';

            }
            tableItemsEntregado = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Entregados</th><th>Unidad</th><th>Tipo</th></tr></thead>' +
                '<tbody>' +
                bodyItemsEntregar+
                '</tbody>'+
                '</table>';
        }else{
            tableItemsEntregado = '<p>Falta verificación</p>';
            $('#btnImprimirItemsEntregar').hide();
        }

        if(response.tipo_categoria_id == '20'){
            $('#btnImprimirItemsEntregar').hide();
        }

        $('#panel-body-items-entregado').empty();
        $('#panel-body-items-entregado').append(tableItemsEntregado);

        $('#verItemsPedidoModal').modal('show');

        $('#btnImprimirItemsSolicitados').prop('href',imp_sol.replace(':id',id));
        if(response.tipo_categoria_id == '20')
            $('#btnImprimirItemsSolicitados').prop('href',imp_tic.replace(':id',id));

        $('#btnImprimirItemsEntregar').prop('href',imp_ent.replace(':id',id));

    });

}

function asignarResponsable(id) {
    $('#modalAsignacion').modal('show');
    $('input[name=pedido_responsable_id]').val(id);
}

function verProgreso(id) {
    var route = rutas.getEstado;
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

        $('#tbodyEstadosPedido').empty();
        var body = "";
        for(var i=0;i<response.estados.length;i++){

            var descripcion = null;
            if(response.estados_pedido[i].motivo!=null){
                descripcion = response.estados_pedido[i].motivo;
            }else{
                descripcion = response.estados[i].descripcion;
            }

            var empleado = "";
            //EMPLEADO VACIO
            if(response.estados_pedido[i].usuario.empleado==null)
                empleado = response.estados_pedido[i].usuario.username;
            else
                empleado=response.estados_pedido[i].usuario.empleado.nombres;

            body+='<tr>' +
                '<td>'+response.estados[i].nombre+'</td>'+
                '<td>'+response.estados_pedido[i].created_at+'</td>'+
                '<td>'+empleado+'</td>'+
                '<td>'+descripcion+'</td>'+
                '</tr>';

        }
        $('#tbodyEstadosPedido').append(body);
        $('#verEstadosPedidoModal').modal('show');
    });

}

function cambiarProceso(id) {
    $('input[name=pedido_proceso_id]').val(id);
    $('#modalConfirmacionProceso').modal('show');
}

function verSalidas(id, estado) {
    var route = rutas.salidas;
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
        $('#accordionSalidaItems').empty();
        var panelSalida = "";
        for(var i=0; i<response.length ; i++){
            var tableBody = "";

            for(var j=0; j<response[i].salida_items.length ;j++){
                var obs = "";

                if(response[i].salida_items[j].observacion != null){
                    obs = response[i].salida_items[j].observacion;
                }
                tableBody+=
                    '<tr>' +
                        '<td>'+(j+1)+'</td>'+
                        '<td>'+response[i].salida_items[j].item_pedido_entregado.item.nombre+'</td>'+
                        '<td>'+response[i].salida_items[j].cantidad+'</td>'+
                        '<td>'+response[i].salida_items[j].item_pedido_entregado.item.unidad.nombre+'</td>'+
                        '<td>'+obs+'</td>'+
                    '</tr>';

            }

            //TRATAMIENTO DE DOCUMENTO
            var spanDoc = "";
            var formInputDoc = "";

            if(response[i].documento == null){
                spanDoc = '<label class="label label-danger pull-right">S/D</label>';
                formInputDoc =
                    '<form action="'+rutas.docStor+'" method="POST" enctype="multipart/form-data">' +

                    '<input name="salida_id" value="'+response[i].id+'" hidden>'+
                    '<input type="hidden" name="_token" value="'+rutas.token+'">'+

                    '<table class="table">' +
                        '<thead><tr><th colspan="3">DOCUMENTO</th></tr></thead>' +
                        '<tbody>' +
                            '<td><input name="documento" type="file" required></td>' +
                            '<td><button type="submit" class="btn btn-default"><i class="fa fa-upload"> </i> Subir Archivo</button></td>' +
                            '<td><a href="'+rutas.pdf.replace(':id',response[i].id)+'" target="_blank" class="btn btn-info-custom"><i class="fa fa-print"> </i> Imprimir</a></td>' +
                        '</tbody>'+
                    '</table>'+

                    '</form>';
            }else{
                var documento = response[i].documento.nombre;
                var extension = documento.replace(/^.*\./, '');

                switch (extension){
                    case 'pdf':
                        formInputDoc = '<iframe src="/js/ViewerJS/?zoom=page-width#/documento/'+response[i].documento.id+'/archivo" width="100%" height="600" allowfullscreen webkitallowfullscreen></iframe>';
                        break;
                    case "png":
                    case "PNG":
                    case "jpeg":
                    case "jpg":
                    case "JPG":
                        formInputDoc = '<img src="'+rutas.docGet.replace(':id',response[i].documento.id)+'" style="width: 100%;">';
                        break;
                }

                spanDoc = '<label class="label label-success pull-right">C/D</label>';
            }
            //*********************************************************

            panelSalida+=
                '<div class="panel-items-listado">'+
                    '<a class="panel-heading" role="tab" data-toggle="collapse" data-parent="#accordion" href="#salida_'+response[i].id+'" aria-expanded="true" aria-controls="collapseOne">'+
                        '<h4 class="panel-title">Salida N°: '+response[i].id+' '+spanDoc+'</h4>'+
                    '</a>'+
                '<div id="salida_'+response[i].id+'" class="panel-collapse collapse" role="tabpanel">'+
                    '<div class="panel-body">'+

                        '<div class="table-responsive">'+
                            '<table class="table table-bordered table-responsive">'+
                                '<thead>'+
                                    '<tr>'+
                                    '<th colspan="5">ITEMS ENTREGADOS</th>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<th width="4%;">Item</th>'+
                                    '<th>Detalle</th>'+
                                    '<th width="6%;">Cantidad</th>'+
                                    '<th width="10%;">U.M.</th>'+
                                    '<th>Observación</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>'+
                                    tableBody+
                                '</tbody>'+
                            '</table>'+
                        '</div>'+

                        '<div class="row">' +
                                formInputDoc+
                        '</div>'+

                    '</div>'+
                '</div>'+
                '</div>';

            if(estado==4){
                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();

                $('#formCompletarPedidoEntregado').prop("action", rutas.comP.replace(':id',id));
                $('#formCompletarPedidoEntregadoTic').prop("action", rutas.comP.replace(':id',id));

                $('#footerModalSalidaPedido').prepend(
                    '<a id="btnCompletarSalida" href="'+rutas.salidasEdit.replace(':id',response[i].pedido_id)+'" class="btn btn-success-custom"><i class="fa fa-check"></i> Completar Salidas</a>'+
                    '<button id="btnCompletarPedido" data-toggle="modal" data-dismiss="modal" data-target="#modalEntregarPedido" type="button" class="btn btn-info-custom pull-left"><i class="fa fa-check-square-o"></i> Completar Pedido</button>'
                );
            }else{
                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();
            }
        }

        $('#accordionSalidaItems').append(
            panelSalida
        );

        $('#verSalidasPedidoModal').modal('show');
    });
}

function verSalidasTic(id, estado) {
    var route = rutas.salidasTic;
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
        $('#accordionSalidaItems').empty();
        var panelSalida = "";
        for(var i=0; i<response.length ; i++){
            var tableBody = "";

            for(var j=0; j<response[i].salida_items_tic.length ;j++){
                var obs = "";

                if(response[i].salida_items_tic[j].observacion != null){
                    obs = response[i].salida_items_tic[j].observacion;
                }
                tableBody+=
                    '<tr>' +
                    '<td>'+(j+1)+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].item_pedido_entregado.item.nombre+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].cantidad+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].item_pedido_entregado.item.unidad.nombre+'</td>'+
                    '<td>'+obs+'</td>'+
                    '</tr>';

            }

            //TRATAMIENTO DE DOCUMENTO
            var spanDoc = "";
            var formInputDoc = "";

            if(response[i].documento == null){
                spanDoc = '<label class="label label-danger pull-right">S/D</label>';
                formInputDoc =
                    '<form action="'+rutas.docStor+'" method="POST" enctype="multipart/form-data">' +

                    '<input name="salida_id" value="'+response[i].id+'" hidden>'+
                    '<input type="hidden" name="_token" value="'+rutas.token+'">'+

                    '<table class="table">' +
                    '<thead><tr><th colspan="3">DOCUMENTO</th></tr></thead>' +
                    '<tbody>' +
                    '<td><input name="documento" type="file" required></td>' +
                    '<td><button type="submit" class="btn btn-default"><i class="fa fa-upload"> </i> Subir Archivo</button></td>' +
                    '<td><a href="'+rutas.pdf.replace(':id',response[i].id)+'" target="_blank" class="btn btn-info-custom"><i class="fa fa-print"> </i> Imprimir</a></td>' +
                    '</tbody>'+
                    '</table>'+

                    '</form>';
            }else{
                var documento = response[i].documento.nombre;
                var extension = documento.replace(/^.*\./, '');

                switch (extension){
                    case 'pdf':
                        formInputDoc = '<iframe src="/js/ViewerJS/?zoom=page-width#/documento/'+response[i].documento.id+'/archivo" width="100%" height="600" allowfullscreen webkitallowfullscreen></iframe>';
                        break;
                    case "png":
                    case "PNG":
                    case "jpeg":
                    case "jpg":
                    case "JPG":
                        formInputDoc = '<img src="'+rutas.docGet.replace(':id',response[i].documento.id)+'" style="width: 100%;">';
                        break;
                }

                spanDoc = '<label class="label label-success pull-right">C/D</label>';
            }
            //*********************************************************

            panelSalida+=
                '<div class="panel-items-listado">'+
                '<a class="panel-heading" role="tab" data-toggle="collapse" data-parent="#accordion" href="#salida_'+response[i].id+'" aria-expanded="true" aria-controls="collapseOne">'+
                '<h4 class="panel-title">Salida N°: '+response[i].id+' '+spanDoc+'</h4>'+
                '</a>'+
                '<div id="salida_'+response[i].id+'" class="panel-collapse collapse" role="tabpanel">'+
                '<div class="panel-body">'+

                '<div class="table-responsive">'+
                '<table class="table table-bordered table-responsive">'+
                '<thead>'+
                '<tr>'+
                '<th colspan="5">ITEMS ENTREGADOS</th>'+
                '</tr>'+
                '<tr>'+
                '<th width="4%;">Item</th>'+
                '<th>Detalle</th>'+
                '<th width="6%;">Cantidad</th>'+
                '<th width="10%;">U.M.</th>'+
                '<th>Observación</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>'+
                tableBody+
                '</tbody>'+
                '</table>'+
                '</div>'+

                '<div class="row">' +
                formInputDoc+
                '</div>'+

                '</div>'+
                '</div>'+
                '</div>';

            if(estado==4){
                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();

                $('#formCompletarPedidoEntregado').prop("action", rutas.comP.replace(':id',id));
                $('#formCompletarPedidoEntregadoTic').prop("action", rutas.comP.replace(':id',id));

                $('#footerModalSalidaPedido').prepend(
                    '<a id="btnCompletarSalida" href="'+rutas.salidasEdit.replace(':id',response[i].pedido_id)+'" class="btn btn-success-custom"><i class="fa fa-check"></i> Completar Salidas</a>'+
                    '<button id="btnCompletarPedido" data-toggle="modal" data-dismiss="modal" data-target="#modalEntregarPedido" type="button" class="btn btn-info-custom pull-left"><i class="fa fa-check-square-o"></i> Completar Pedido</button>'
                );
            }else{
                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();
            }
        }

        $('#accordionSalidaItems').append(
            panelSalida
        );

        $('#verSalidasPedidoModal').modal('show');
    });
}

function tipoBusqueda() {
    var tipo = $('#selectTipo').val();

    if(tipo == "columnas"){
        buscarPedido();
    }else{
        buscarPedidoXItem();
    };
}
function buscarPedido() {
    var route = rutas.buscar;
    var token = rutas.token;
    var texto = $('#txtBuscarPedido').val();
    var tipo = $('#selectTipo').val();
    if(!isEmptyOrSpaces(texto)){ //NO VACIO
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data:{
                texto: texto
            },
            dataType: 'JSON',
            beforeSend: function(e){
                $('#contenido-tab').empty();
                $('#contenido-tab').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                    '<i class="fa fa-spin fa-spinner"></i><strong> Buscando</strong> pedidos...'+
                    '</div>');
            }
        }).done(function (response){
            console.log(response);
            var head = "";
            var body = "";
            var table = "";

            switch ( parseInt(variables.uR)){
                case 1://R
                case 2://AD
                case 3://AS
                case 4://RE
                case 5://AU
                case 9://WATCHE
                case 8:
                case 10:
                case 11:
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo' +
                        '</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Creado en</th><th>Estado</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                    break;
                case 6://US
                case 7://R.ENT.
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Creado en</th><th>Estado</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                    break;
            }

            //************************************CUERPO
            var aux = 0;
            $.each(response, function (index, value) {
                var responsable = "SIN ENCARGADO";

                if(response[index].asignados_nombres!=null && response[index].asignados_nombres.length > 0){
                    for(var j=0;j<response[index].asignados_nombres.length;j++){
                        responsable=response[index].asignados_nombres[j].empleado_nombres.nombres;
                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_1;

                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                    }
                }

                var estado = "";
                var estado_nombre = response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado.nombre;
                switch (parseInt(variables.uR)){
                    case 1://R
                    case 2://AD
                        var opciones = "";
                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        if(response[i].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        break;
                    case 9://WATCHER
                        var opciones = "";
                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        if(response[index].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[index].id+');" title="Ver documentos '+response[index].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        break;
                    case 3://AS
                    case 10:
                        var opciones = "";
                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 4://RE
                    case 11:
                        var opciones = "";
                        //************************************ASIGNADO
                        var bool_asignado_opciones = false;
                        var responsable = "SIN ENCARGADO";
                        if(response[index].asignados_nombres!=null && response[index].asignados_nombres.length > 0){
                            for(var j=0;j<response[index].asignados_nombres.length;j++){
                                responsable=response[index].asignados_nombres[j].empleado_nombres.nombres;
                                if(response[index].asignados_nombres[j].id==variables.uI)
                                    bool_asignado_opciones = true;

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_1;

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_3+' ';
                            }
                        }
                        //************************************

                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 4);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<a href="'+rutas.salidasEdit.replace(':id',response[index].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 5);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                if(bool_asignado_opciones){
                                    var penultimo_estado =  response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length-2].estado_id;
                                    for(var k=response[index].estados_pedido_detalle.length-1;k>0;k--){
                                        if(response[index].estados_pedido_detalle[k].estado_id!=9){
                                            penultimo_estado = response[index].estados_pedido_detalle[k].estado_id;
                                            break;
                                        }
                                    }
                                    switch (parseInt(penultimo_estado)){
                                        case 3: //PENULTIMO ESTADO - ASIGNADO
                                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                                '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                            break;
                                        case 4: //PENULTIMO ESTADO - PARCIAL
                                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 4);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                                '<a href="'+rutas.salidasEdit.replace(':id',response[index].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                            break;
                                    }
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 5://AU
                        var opciones = "";
                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>';
                                if(variables.uI==response[index].solicitante_id){
                                    opciones+='<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                                }
                                opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 6://US
                    case 7://R.ENT.
                        var opciones = "";
                        switch ( parseInt(response[index].estados_pedido_detalle[response[index].estados_pedido_detalle.length - 1].estado_id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                        //REVISOR AF
                        case 8:
                        //************************************OPCIONES
                        var opciones = "";
                        switch (parseInt(estado)){
                            case 1:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 2:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[index].id)+'" title="Verificar Activos Fijos de pedido '+response[i].codigo+'"><i class="fa fa-tags"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 3:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 4:
                            case 5:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 6:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>';
                                if(variables.uI==response[index].solicitante_id){
                                    opciones+='<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                                }
                                opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 7:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 8:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 9:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 10:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                            case 11:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[index].id)+'" title="Verificar Activos Fijos de pedido '+response[index].codigo+'"><i class="fa fa-tags"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                break;
                        }
                        if(response[index].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[index].id+');" title="Ver documentos '+response[index].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        //************************************
                        var responsable = "SIN ENCARGADO";
                        if(response[index].asignados_nombres!=null && response[index].asignados_nombres.length > 0){
                            for(var j=0;j<response[index].asignados_nombres.length;j++){
                                responsable=response[index].asignados_nombres[j].empleado_nombres.nombres;
                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_1;

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                            }
                        }
                        //************************************CUERPO
                        var proyecto = "SIN PROYECTO";
                        var empresa = "SIN EMPRESA";
                        if(response[index].proyecto_empresa!=null){
                            proyecto = response[index].proyecto_empresa.nombre;
                            empresa = response[index].proyecto_empresa.empresa.nombre
                        }

                            body+='<tr><th scope="row">'+(index+1)+'</th>' +
                                '<td>'+response[index].codigo+'</td>' +
                                '<td>'+proyecto+'</td>' +
                                '<td>'+empresa+'</td>' +
                                '<td>'+response[index].solicitante_empleado.empleado.nombres+' '+response[index].solicitante_empleado.empleado.apellido_1+' '+response[index].solicitante_empleado.empleado.apellido_2+'</td>' +
                                '<td>'+responsable+'</td>' +
                                '<td>'+response[index].created_at+'</td>' +
                                '<td><div class="btn-group" role="group">' +
                                opciones+
                                '</div></td>'+
                                '</tr>';


                        //************************************
                        break;
                }


                body += '<tr><th scope="row">' + (aux + 1) + '</th>' +
                    '<td>' + response[index].codigo + '</td>' +
                    '<td>' + response[index].proyecto_empresa.empresa.nombre + '</td>' +
                    '<td>' + response[index].proyecto_empresa.nombre + '</td>' +
                    '<td>' + response[index].solicitante_empleado.empleado.nombres + ' ' + response[index].solicitante_empleado.empleado.apellido_1 + ' ' + response[index].solicitante_empleado.empleado.apellido_2 + '</td>' +
                    '<td>' + responsable + '</td>' +
                    '<td>' + response[index].created_at + '</td>' +
                    '<td>'+estado+'</td>'+
                    '<td><div class="btn-group" role="group">' +
                    opciones +
                    '</div></td>' +
                    '</tr>';

                aux++;
            });
            table=
                head+
                body+
                '</tbody>'+
                '</table>';

            $('#contenido-tab').empty();
            $('#contenido-tab').append('<div class="input-group col-md-12"><div class="col-md-3">' +
                '<select id="selectTipo" class="form-control js-placeholder-single">' +
                '<option value="" disabled selected>Seleccione tipo de búsqueda...</option>'+
                '<option value="columnas">BÚSQUEDA POR COLUMNAS</option>' +
                '<option value="item">BÚSQUEDA POR ITEMS</option>' +
                '</select>'+
                '</div>' +
                '<div class="col-md-9">' +
                '<div class="input-group">' +
                '<input id="txtBuscarPedido" style="height: 34px !important;" value="'+texto+'" type="text" class="form-control" placeholder=" Buscar...">'+
                '<span class="input-group-btn">' +
                '<button class="btn btn-default" type="button" onclick="tipoBusqueda();"><i class="fa fa-search"></i></button>' +
                '</span>'+
                '</div>' +
                '</div>'+
            '</div>');
            $('#contenido-tab').append('<h4 style="color: white; background-color: #2a3f54;padding: 10px"><i class="fa fa-search"></i> Búsqueda por Columnas</h4>');
            $('#contenido-tab').append(table);

            $('.js-placeholder-single').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val('').trigger('change');
        });


    }else{ //VACIO
        $('#contenido-tab').append('<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<i class="fa fa-close"></i><strong> Vacio</strong> no escribio nada para realizar la busqueda'+
            '</div>');
    }


}

function buscarPedidoXItem() {
    var route = rutas.buscarItem;
    var token = rutas.token;
    var texto = $('#txtBuscarPedido').val();
    if(!isEmptyOrSpaces(texto)){ //NO VACIO
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data:{
                texto: texto
            },
            dataType: 'JSON',
            beforeSend: function(e){
                $('#contenido-tab').empty();

                $('#contenido-tab').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                    '<i class="fa fa-spin fa-spinner"></i><strong> Buscando</strong> pedidos...'+
                    '</div>');
            }
        }).done(function (response){
            console.log(response);
            var head = "";
            var body = "";
            var table = "";

            switch ( parseInt(variables.uR)){
                case 1://R
                case 2://AD
                case 3://AS
                case 4://RE
                case 5://AU
                case 9://WATCHER
                case 8: //AF
                case 10: //REV TICS
                case 11: //RESP TICS
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo' +
                        '</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Items</th><th>Estado</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                    break;
                case 6://US
                case 7://R.ENT.
                    head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Items</th><th>Estado</th><th>Opciones</th></tr></thead>'+
                        '<tbody>';
                    break;
            }

            //************************************CUERPO
            var aux = 0;
            $.each(response, function (index, value) {
                var responsable = "SIN ENCARGADO";

                if(response[index].asignados_nombres!=null && response[index].asignados_nombres.length > 0){
                    for(var j=0;j<response[index].asignados_nombres.length;j++){
                        responsable=response[index].asignados_nombres[j].empleado_nombres.nombres;
                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_1;

                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                        if(response[index].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                            responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                    }
                }

                var estado = "";
                console.log("--------->"+variables.uR);
                var estado_nombre = response[index].estados[response[index].estados.length - 1].nombre;
                switch (parseInt(variables.uR)){
                    case 1://R
                    case 2://AD
                        var opciones = "";
                        // console.log("--------->"+parseInt(response[index].estados[response[index].estados.length - 1].id));
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        if(response[index].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[index].id+');" title="Ver documentos '+response[index].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        break;
                    case 9://WATCHER
                        var opciones = "";
                        // console.log("--------->"+parseInt(response[index].estados[response[index].estados.length - 1].id));
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizadoTic('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        if(response[index].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[index].id+');" title="Ver documentos '+response[index].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        break;
                    case 3://AS
                    case 10://AS
                        var opciones = "";
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.asignadorEdit.replace(":id",response[index].id)+'" title="Asignar pedido '+response[index].codigo+'" onclick="asignarPedido('+response[index].id+');"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 4://RE
                    case 11:
                        var opciones = "";
                        //************************************ASIGNADO
                        var bool_asignado_opciones = false;
                        var responsable = "SIN ENCARGADO";
                        if(response[index].asignados_nombres!=null && response[index].asignados_nombres.length > 0){
                            for(var j=0;j<response[index].asignados_nombres.length;j++){
                                responsable=response[index].asignados_nombres[j].empleado_nombres.nombres;
                                if(response[index].asignados_nombres[j].id==variables.uI)
                                    bool_asignado_opciones = true;

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_1;

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                                if(response[index].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                    responsable+=' '+response[index].asignados_nombres[j].empleado_nombres.apellido_3+' ';
                            }
                        }
                        //************************************

                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 4);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<a href="'+rutas.salidasEdit.replace(':id',response[index].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 5);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                if(bool_asignado_opciones){
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                if(bool_asignado_opciones){
                                    var penultimo_estado =  response[index].estados[response[index].estados.length-2].estado_id;
                                    for(var k=response[index].estados.length-1;k>0;k--){
                                        if(response[index].estados[k].estado_id!=9){
                                            penultimo_estado = response[index].estados[k].estado_id;
                                            break;
                                        }
                                    }
                                    switch (parseInt(penultimo_estado)){
                                        case 3: //PENULTIMO ESTADO - ASIGNADO
                                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                                '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                            break;
                                        case 4: //PENULTIMO ESTADO - PARCIAL
                                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[index].id+', 4);" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                                '<a href="'+rutas.salidasEdit.replace(':id',response[index].id)+'" class="btn btn-success-custom" title="Completar salidas '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                            break;
                                    }
                                }else{
                                    opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                        '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                }
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 5://AU
                        var opciones = "";
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[index].id)+'" title="Verificar pedido '+response[index].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>';
                                if(variables.uI==response[index].solicitante_id){
                                    opciones+='<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                                }
                                opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';

                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 6://US
                    case 7://R.ENT.
                        var opciones = "";
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){

                            case 1://INICIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2://AUTORIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3://ASIGNADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4://PARCIAL
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';
                                break;
                            case 5://ENTREGADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6://OBSERVADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a href="'+rutas.editPedido.replace(":id",response[index].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7://RECHAZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8://FINALIZADO
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[index].id+');" title="Ver salidas del pedido '+response[index].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9://EN ESPERA
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[index].id+');" title="Ver lista '+response[index].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[index].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                        }
                        break;
                    case 8:
                        //REVISOR AF

                        //************************************OPCIONES
                        var opciones = "";
                        var i = index;
                        switch (parseInt(response[index].estados[response[index].estados.length - 1].id)){
                            case 1:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAutorizador.replace(":id",response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"> '+ estado_nombre +'</label>';
                                break;
                            case 2:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[i].id)+'" title="Verificar Activos Fijos de pedido '+response[i].codigo+'"><i class="fa fa-tags"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 3:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-info"><i class="fa fa-user"></i> '+ estado_nombre +'</label>';
                                break;
                            case 4:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning">'+ estado_nombre +'</label>';

                                break;
                            case 5:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-paper-plane"></i> '+ estado_nombre +'</label>';
                                break;
                            case 6:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>';
                                if(variables.uI==response[i].solicitante_id){
                                    opciones+='<a href="'+rutas.editPedido.replace(":id",response[i].id)+'" class="btn btn-success-custom" title="Editar pedido"><i class="fa fa-edit"></i></a>';
                                }
                                opciones+='<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-warning"><i class="fa fa-eye"></i> '+ estado_nombre +'</label>';
                                break;
                            case 7:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-danger">'+ estado_nombre +'</label>';
                                break;
                            case 8:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-check"></i> '+ estado_nombre +'</label>';
                                break;
                            case 9:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-success"><i class="fa fa-clock-o"></i> '+ estado_nombre +'</label>';
                                break;
                            case 10:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-primary"> '+ estado_nombre +'</label>';
                                break;
                            case 11:
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<a class="btn btn-success-custom" href="'+rutas.verificacionAF.replace(":id",response[i].id)+'" title="Verificar Activos Fijos de pedido '+response[i].codigo+'"><i class="fa fa-tags"></i></a>'+
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                estado+='<label class="label label-primary"> '+ estado_nombre +'</label>';
                                break;
                        }
                        if(response[i].documentos.length > 0){
                            opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                        }
                        //************************************
                        var responsable = "SIN ENCARGADO";
                        if(response[i].asignados_nombres!=null && response[i].asignados_nombres.length > 0){
                            for(var j=0;j<response[i].asignados_nombres.length;j++){
                                responsable=response[i].asignados_nombres[j].empleado_nombres.nombres;
                                if(response[i].asignados_nombres[j].empleado_nombres.apellido_1!=null)
                                    responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_1;

                                if(response[i].asignados_nombres[j].empleado_nombres.apellido_2!=null)
                                    responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_2+' ';

                                if(response[i].asignados_nombres[j].empleado_nombres.apellido_3!=null)
                                    responsable+=' '+response[i].asignados_nombres[j].empleado_nombres.apellido_3+' ';

                            }
                        }

                        //************************************
                        break;
                }

                var listaItems = "";
                for(var i=0; i<response[index].items.length;i++){
                   // console.log(response[index].items[i].nombre);
                    var buscarNombre = response[index].items[i].nombre.toLowerCase();
                    if(buscarNombre.indexOf(texto.toLowerCase()) > -1){
                        console.log(response[index].items[i].nombre);
                        listaItems += '<li>'+response[index].items[i].nombre+'</li>'
                    }
                }
                for(var i=0; i<response[index].items_temporales.length;i++){
                    // console.log(response[index].items[i].nombre);
                    var buscarNombre = response[index].items_temporales[i].nombre.toLowerCase();
                    if(buscarNombre.indexOf(texto.toLowerCase()) > -1){
                        console.log(response[index].items_temporales[i].nombre);
                        listaItems += '<li style="background-color: rgba(255,252,22,0.25)">'+response[index].items_temporales[i].nombre+'</li>'
                    }
                }
                for(var i=0; i<response[index].items_entregar.length;i++){
                    // console.log(response[index].items[i].nombre);
                    var buscarNombre = response[index].items_entregar[i].nombre.toLowerCase();
                    if(buscarNombre.indexOf(texto.toLowerCase()) > -1){
                        console.log(response[index].items_entregar[i].nombre);
                        listaItems += '<li style="background-color: rgba(27,126,90,0.3)">'+response[index].items_entregar[i].nombre+'</li>'
                    }
                }

                console.log("--------->"+opciones);
                body += '<tr><th scope="row">' + (aux + 1) + '</th>' +
                    '<td>' + response[index].codigo + '</td>' +
                    '<td>' + response[index].proyecto_empresa.empresa.nombre + '</td>' +
                    '<td>' + response[index].proyecto_empresa.nombre + '</td>' +
                    '<td>' + response[index].solicitante_empleado.empleado.nombres + ' ' + response[index].solicitante_empleado.empleado.apellido_1 + ' ' + response[index].solicitante_empleado.empleado.apellido_2 + '</td>' +
                    '<td>' + responsable + '</td>' +
                    '<td><ul style="list-style-type: none;padding-left: 0;">' + listaItems + '</ul></td>' +
                    '<td>'+estado+'</td>'+
                    '<td><div class="btn-group" role="group">' +
                    opciones +
                    '</div></td>' +
                    '</tr>';

                aux++;
            });

            table=
                head+
                body+
                '</tbody>'+
                '</table>';

            $('#contenido-tab').empty();
            $('#contenido-tab').append('<div class="input-group col-md-12"><div class="col-md-3">' +
                '<select id="selectTipo" class="form-control js-placeholder-single">' +
                '<option value="" disabled selected>Seleccione tipo de búsqueda...</option>'+
                '<option value="columnas">BÚSQUEDA POR COLUMNAS</option>' +
                '<option value="item">BÚSQUEDA POR ITEMS</option>' +
                '</select>'+
                '</div>' +
                '<div class="col-md-9">' +
                '<div class="input-group">' +
                '<input id="txtBuscarPedido" style="height: 34px !important;" value="'+texto+'" type="text" class="form-control" placeholder=" Buscar...">'+
                '<span class="input-group-btn">' +
                '<button class="btn btn-default" type="button" onclick="tipoBusqueda();"><i class="fa fa-search"></i></button>' +
                '</span>'+
                '</div>' +
                '</div></div>');
            $('#contenido-tab').append('<h4 style="color: white; background-color: #2a3f54;padding: 10px"><i class="fa fa-search"></i> Búsqueda por Items</h4>');
            $('#contenido-tab').append('<div style="text-align: center" class="row"><div class="col-md-4"><p>ITEMS PEDIDOS</p></div><div class="col-md-4"><p style="background-color: rgba(255,252,22,0.25)">ITEMS TEMPORALES</p></div><div class="col-md-4"><p style="background-color: rgba(27,126,90,0.3)">ITEMS ENTREGADOS</p></div></div>');
            $('#contenido-tab').append(table);

            $('.js-placeholder-single').select2({
                allowClear: true,
                placeholder: "Seleccione...",
                width: '100%'
            }).val('').trigger('change');
        });
    }else{ //VACIO
        $('#contenido-tab').append('<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<i class="fa fa-close"></i><strong> Vacio</strong> no escribio nada para realizar la busqueda'+
            '</div>');
    }


}

function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}

function verDocumentos(id) {
    var route = rutas.docPed;
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
        },
        error: function(e){
            $('#modalErrorDocumento').modal('show');
        }
    }).done(function (response){
        console.log(response.error);
        var tr = '';
        if(response.error == 'error_documentos' && response.error!=null){
            tr+='<tr><td colspan="4"><div id="advertencia" class="alert alert-danger alert-dismissible fade in" role="alert">' +
                'No se encontraron los documentos asignados a este pedido. Por favor comuníquese con el Área de Sistemas al <strong>teléfono de soporte (1610)</strong>, atenderemos su solicitud a la brevedad posibe.' +
                '</div></td></tr>';
        }else{
            for(var i=0 ; i<response.length ;i++){
                var descargar = rutas.descDoc;
                descargar = descargar.replace(':id',response[i].id);
                tr+='<tr>'+
                    '<th scope="row">'+(i+1)+'</th>'+
                    '<td>'+response[i].nombre+'</td>'+
                    '<td>'+getReadableFileSizeString(response[i].size)+'</td>'+
                    '<td><div class="btn-group" role="group"><a href="'+descargar+'" class="btn btn-success-custom" title="Descargar '+response[i].nombre+'"><i class="fa fa-download"></i></a>' +
                    '<button title="Ver '+response[i].nombre+'" onclick="mostrarArchivo(\''+response[i].ubicacion+'\',\''+response[i].nombre+'\','+response[i].id+')" class="btn btn-warning-custom"><i class="fa fa-eye"></i></button>' +
                    '</div></td>'+
                    '</tr>';


            }
            // $('#tbodyDoc').empty();
            // $('#tbodyDoc').append(tr);
        }
        $('#tbodyDoc').empty();
        $('#tbodyDoc').append(tr);
        $('#modalDocumentos').modal('show');
    });

}

function mostrarArchivo(response, nombre, id) {

    console.log(rutas.docGet.replace(':id',id));
    var documento = nombre;
    var extension = documento.replace(/^.*\./, '');
    console.log(extension);
   $('#filepdf').empty();
    $('#filepdf').toggle();
    switch (extension){
        case 'pdf':
            PDFObject.embed(rutas.docGet.replace(':id',id), "#filepdf");
            break;
        case "png":
        case "PNG":
        case "jpeg":
        case "jpg":
        case "JPG":
            imagen = '<img src="'+rutas.docGet.replace(':id',id)+'" style="width: 100%;">';
            $('#filepdf').append(imagen);
            break;
        default:
            advertencia = '<div id="advertencia" class="alert alert-info alert-dismissible fade in" role="alert">No se puede visualizar el archivo porque no está en formato PDF ni es una imagen. Por favo descarguelo para poder verlo en su computadora.</div>';
            $('#filepdf').append(advertencia);
            break;
    }

//    PDFObject.embed('storage/'+response, "#filepdf");
   // PDFObject.embed('storage/'+ubicacion, "#filepdf");
}

function mostrarArchivoSalida(id) {
    $('#salpdf'+id).toggle();
    PDFObject.embed(rutas.docGet.replace(':id',id), "#salpdf"+id);
}

function verSalidasFinalizado(id) {
    var route = rutas.salidas;
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
        $('#accordionSalidaItems').empty();
        var panelSalida = "";
        for(var i=0; i<response.length ; i++){
            var tableBody = "";

            for(var j=0; j<response[i].salida_items.length ;j++){
                var obs = "";

                if(response[i].salida_items[j].observacion != null){
                    obs = response[i].salida_items[j].observacion;
                }
                tableBody+=
                    '<tr>' +
                    '<td>'+(j+1)+'</td>'+
                    '<td>'+response[i].salida_items[j].item_pedido_entregado.item.nombre+'</td>'+
                    '<td>'+response[i].salida_items[j].cantidad+'</td>'+
                    '<td>'+response[i].salida_items[j].item_pedido_entregado.item.unidad.nombre+'</td>'+
                    '<td>'+obs+'</td>'+
                    '</tr>';
            }

            //TRATAMIENTO DE DOCUMENTO
            var spanDoc = "";
            var formInputDoc = "";

            if(response[i].documento == null){
                spanDoc = '<label class="label label-danger pull-right">S/D</label>';
                fila = '<th colspan="5">ITEMS ENTREGADOS </th>';
            }else{
                fila = '<th colspan="5">ITEMS ENTREGADOS <button onclick="mostrarArchivoSalida('+response[i].documento.id+')" class="btn btn-default pull-right"><i class="fa fa-eye"></i> Ver Archivo</button></th>';
                var documento = response[i].documento.nombre;
                var extension = documento.replace(/^.*\./, '');

                switch (extension){
                    case 'pdf':
                        console.log('PDFFFF');
                        formInputDoc = '<div id="salpdf'+response[i].documento.id+'" hidden></div>';

                       break;
                    case "png":
                    case "PNG":
                    case "jpeg":
                    case "jpg":
                    case "JPG":
                        formInputDoc = '<img src="'+rutas.docGet.replace(':id',response[i].documento.id)+'" style="width: 100%;">';
                        break;
                }

                spanDoc = '<label class="label label-success pull-right">C/D</label>';
            }
            //*********************************************************

            panelSalida+=
                '<div class="panel-items-listado">'+
                '<a class="panel-heading" role="tab" data-toggle="collapse" data-parent="#accordion" href="#salida_'+response[i].id+'" aria-expanded="true" aria-controls="collapseOne">'+
                '<h4 class="panel-title">Salida N°: '+response[i].id+' '+spanDoc+'</h4>'+
                '</a>'+
                '<div id="salida_'+response[i].id+'" class="panel-collapse collapse" role="tabpanel">'+
                '<div class="panel-body">'+

                '<div class="table-responsive">'+
                '<table class="table table-bordered table-responsive">'+
                    '<thead>'+
                        '<tr>'+
                            fila+
                            '</tr>'+
                            '<tr>'+
                            '<th width="4%;">Item</th>'+
                            '<th>Detalle</th>'+
                            '<th width="6%;">Cantidad</th>'+
                            '<th width="10%;">U.M.</th>'+
                            '<th>Observación</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        tableBody+
                    '</tbody>'+
                '</table>'+
                '</div>'+

                '<div class="row">' +
                    formInputDoc+
                '</div>'+

                '</div>'+
                '</div>'+
                '</div>';


                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();

        }

        $('#accordionSalidaItems').append(
            panelSalida
        );

        $('#verSalidasPedidoModal').modal('show');
        PDFObject.embed(rutas.docGet.replace(':id',response[i].documento.id), "#salpdf");
    });
}

function verSalidasFinalizadoTic(id) {
    var route = rutas.salidasTic;
    var token = rutas.token;
    console.log("SALIDA FINALIZADO SADSADSA: "+route);
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
        console.log("SALIDA FINALIZADO: "+response);
        $('#accordionSalidaItems').empty();
        var panelSalida = "";
        for(var i=0; i<response.length ; i++){
            var tableBody = "";

            for(var j=0; j<response[i].salida_items_tic.length ;j++){
                var obs = "";

                if(response[i].salida_items_tic[j].observacion != null){
                    obs = response[i].salida_items_tic[j].observacion;
                }
                tableBody+=
                    '<tr>' +
                    '<td>'+(j+1)+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].item_pedido_entregado.item.nombre+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].cantidad+'</td>'+
                    '<td>'+response[i].salida_items_tic[j].item_pedido_entregado.item.unidad.nombre+'</td>'+
                    '<td>'+obs+'</td>'+
                    '</tr>';
            }

            //TRATAMIENTO DE DOCUMENTO
            var spanDoc = "";
            var formInputDoc = "";
            var fila = "";
            if(response[i].documento == null){
                spanDoc = '<label class="label label-danger pull-right">S/D</label>';
                fila = '<th colspan="5">ITEMS ENTREGADOS </th>';
            }else{
                fila = '<th colspan="5">ITEMS ENTREGADOS <button onclick="mostrarArchivoSalida('+response[i].documento.id+')" class="btn btn-default pull-right"><i class="fa fa-eye"></i> Ver Archivo</button></th>';
                var documento = response[i].documento.nombre;
                var extension = documento.replace(/^.*\./, '');

                switch (extension){
                    case 'pdf':
                        // formInputDoc = '<iframe src="/js/ViewerJS/?zoom=page-width#/documento/'+response[i].documento.id+'/archivo" width="100%" height="600" allowfullscreen webkitallowfullscreen></iframe>';
                        formInputDoc = '<div id="salpdf'+response[i].documento.id+'" hidden></div>';
                        break;
                    case "png":
                    case "PNG":
                    case "jpeg":
                    case "jpg":
                    case "JPG":
                        formInputDoc = '<img src="'+rutas.docGet.replace(':id',response[i].documento.id)+'" style="width: 100%;">';
                        break;
                }

                spanDoc = '<label class="label label-success pull-right">C/D</label>';
            }
            //*********************************************************

            panelSalida+=
                '<div class="panel-items-listado">'+
                '<a class="panel-heading" role="tab" data-toggle="collapse" data-parent="#accordion" href="#salida_'+response[i].id+'" aria-expanded="true" aria-controls="collapseOne">'+
                '<h4 class="panel-title">Salida N°: '+response[i].id+' '+spanDoc+'</h4>'+
                '</a>'+
                '<div id="salida_'+response[i].id+'" class="panel-collapse collapse" role="tabpanel">'+
                '<div class="panel-body">'+

                '<div class="table-responsive">'+
                '<table class="table table-bordered table-responsive">'+
                '<thead>'+
                '<tr>'+
                fila+
                '</tr>'+
                '<tr>'+
                '<th width="4%;">Item</th>'+
                '<th>Detalle</th>'+
                '<th width="6%;">Cantidad</th>'+
                '<th width="10%;">U.M.</th>'+
                '<th>Observación</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>'+
                tableBody+
                '</tbody>'+
                '</table>'+
                '</div>'+

                '<div class="row">' +
                formInputDoc+
                '</div>'+

                '</div>'+
                '</div>'+
                '</div>';


            $('#btnCompletarSalida').remove();
            $('#btnCompletarPedido').remove();

        }

        $('#accordionSalidaItems').append(
            panelSalida
        );

        $('#verSalidasPedidoModal').modal('show');
    });
}