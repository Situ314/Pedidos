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
    }).val('').trigger('change');

    //Agregando rutas como variables clobales
    verificacion = rutas.verificacion.replace(":id","");
    verifiAut = rutas.verificacionAutorizador.replace(":id","");
    getTabla();

    setInterval(setTabsCantidad, 5000);
});

$('ul#myTab li a').click(function (e) {
    var estado = this.id.split('-tab')[0];

    var route = rutas.pedidos;
    var token = rutas.token;

    if(estado!=""){

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
    for(var i=0 ; i < $('#myTab').children().length ; i++){
        if( $($('#myTab').children()[i]).hasClass("active") ){
            estado = $($('#myTab').children()[i]).children().children().prop('id').split('-tab-cantidad')[0];
        }
    }

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

function actualizarTabla(response, estado) {
    var head = "";
    var body = "";
    var table = "";

    if(response.length!=0){
        switch ( parseInt(variables.uR)){
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Solicitante:</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                    '<tbody>';
                break;
            case 6:
                head += '<table class="table"><thead><tr><th>#</th><th>Codigo</th><th>Empresa</th><th>Proyecto</th><th>Asignado a:</th><th>Creado en</th><th>Opciones</th></tr></thead>'+
                    '<tbody>';
                break;
        }
        for(var i=0;i<response.length;i++){
            switch (parseInt(variables.uR)){
                case 1:
                case 2:
                case 3:
                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
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
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    var responsable = "SIN ENCARGADO";
                    if(response[i].asignados!=null && response[i].asignados.length > 0){
                        for(var j=0;j<response[i].asignados.length;j++){
                            console.log(response[i].asignados[j].empleado_nombres);
                            responsable=response[i].asignados[j].empleado_nombres.nombres;
                            if(response[i].asignados[j].empleado_nombres.apellido_1!=null)
                                responsable+=' '+response[i].asignados[j].empleado_nombres.apellido_1;

                            if(response[i].asignados[j].empleado_nombres.apellido_2!=null)
                                responsable+=' '+response[i].asignados[j].empleado_nombres.apellido_2+' ';

                            if(response[i].asignados[j].empleado_nombres.apellido_3!=null)
                                responsable+=' '+response[i].asignados[j].empleado_nombres.apellido_3+' ';

                        }
                    }

                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                        '<td>'+response[i].proyecto.nombre+'</td>' +
                        '<td>'+response[i].solicitante.empleado.nombres+' '+response[i].solicitante.empleado.apellido_1+' '+response[i].solicitante.empleado.apellido_2+'</td>' +
                        '<td>'+responsable+'</td>' +
                        '<td>'+response[i].created_at+'</td>' +
                        '<td><div class="btn-group" role="group">' +
                        opciones+
                        '</div></td>'+
                        '</tr>';
                    //************************************
                    break;
                case 4:
                    //************************************OPCIONES
                    var opciones = "";
                    switch (parseInt(estado)){
                        case 1:
                        case 2:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 3:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<a class="btn btn-success-custom" href="'+rutas.verificacionResponsable.replace(':id',response[i].id)+'" title="Verificar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 4:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>'+
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[i].id+', 4);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 5:
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidas('+response[i].id+', 5);" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
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
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                        '<td>'+response[i].proyecto.nombre+'</td>' +
                        '<td>'+response[i].created_at+'</td>' +
                        '<td>'+response[i].solicitante.empleado.nombres+' '+response[i].solicitante.empleado.apellido_1+' '+response[i].solicitante.empleado.apellido_2+'</td>' +
                        '<td><div class="btn-group" role="group">' +
                        opciones+
                        '</div></td>'+
                        '</tr>';
                    //************************************
                    break;
                case 5:
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
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                        '<td>'+response[i].proyecto.nombre+'</td>' +
                        '<td>'+response[i].solicitante.empleado.nombres+' '+response[i].solicitante.empleado.apellido_1+' '+response[i].solicitante.empleado.apellido_2+'</td>' +
                        '<td>'+response[i].created_at+'</td>' +
                        '<td><div class="btn-group" role="group">' +
                        opciones+
                        '</div></td>'+
                        '</tr>';
                    //************************************
                    break;
                case 6:
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
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto.empresa.nombre+'</td>' +
                        '<td>'+response[i].proyecto.nombre+'</td>' +
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
        table += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
            '</div>';
    }

    $('#contenido-tab').empty();
    $('#contenido-tab').append(table);
}

function verItems(id) {
    var route = rutas.getItem;
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
        var contItemsPedidos = 1;
        if(response.items_pedido.length>0 || response.items_temp_pedido.length>0){
            var bodyItems = '';
            for(var i=0;i<response.items_temp_pedido.length;i++){
                bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                    '<td>'+response.items_temp_pedido[i].item.nombre+'</td>' +
                    '<td>'+response.items_temp_pedido[i].cantidad+'</td>' +
                    '<td>'+response.items_temp_pedido[i].item.unidad.nombre+' ('+response.items_temp_pedido[i].item.unidad.descripcion+')</td>' +
                    '<td><label class="label label-warning">Item Temporal</label></tr>';

                contItemsPedidos++;
            }
            for(var i=0;i<response.items_pedido.length;i++){
                bodyItems += '<tr><th scope="row">'+contItemsPedidos+'</th>' +
                    '<td>'+response.items_pedido[i].item.nombre+'</td>' +
                    '<td>'+response.items_pedido[i].cantidad+'</td>' +
                    '<td>'+response.items_pedido[i].item.unidad.nombre+' ('+response.items_pedido[i].item.unidad.descripcion+')</td>'+
                    '<td><label class="label label-success">Item Registrado</label></tr>';

                contItemsPedidos++;
            }
            tableItems = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Unidad</th><th>Tipo</th></tr></thead>' +
                '<tbody>' +
                    bodyItems+
                '</tbody>'+
                '</table>';
        }else {
            tableItems = '<p>No hay items en el listado</p>'
        }

        $('#panel-body-items').empty();
        $('#panel-body-items').append(tableItems);

        var tableItemsEntregado='';

        if(response.items_entrega.length!=0){
            var bodyItemsEntregar = '';
            for(var i=0;i<response.items_entrega.length;i++){
                bodyItemsEntregar += '<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response.items_entrega[i].item.nombre+'</td>' +
                    '<td>'+response.items_entrega[i].cantidad+'</td>' +
                    '<td>'+response.items_entrega[i].item.unidad.nombre+' ('+response.items_entrega[i].item.unidad.descripcion+')</td>'+
                    '<td><label class="label label-success">Item Registrado</label></tr>';

            }
            tableItemsEntregado = '<table class="table table-bordered"><thead><tr><th>#</th><th>Item</th><th>Cantidad</th><th>Unidad</th><th>Tipo</th></tr></thead>' +
                '<tbody>' +
                bodyItemsEntregar+
                '</tbody>'+
                '</table>';
        }else{
            tableItemsEntregado = '<p>Falta verificación</p>';
        }

        $('#panel-body-items-entregado').empty();
        $('#panel-body-items-entregado').append(tableItemsEntregado);

        $('#verItemsPedidoModal').modal('show');

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
                            '<td><button type="submit" class="btn btn-default"><i class="fa fa-upload"> Subir Archivo</i></button></td>' +
                            '<td><a href="'+rutas.pdf.replace(':id',response[i].id)+'" target="_blank" class="btn btn-info-custom"><i class="fa fa-print"> Imprimir</i></a></td>' +
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

                $('#footerModalSalidaPedido').prepend(
                    '<a id="btnCompletarSalida" href="'+rutas.salidasEdit.replace(':id',response[i].pedido_id)+'" class="btn btn-info-custom"><i class="fa fa-check"></i> Completar Salidas</a>'+
                    '<button id="btnCompletarPedido" data-toggle="modal" data-dismiss="modal" data-target="#modalEntregarPedido" type="button" class="btn btn-success-custom pull-left"><i class="fa fa-check-square-o"></i> Completar Pedido</button>'
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

function buscarPedido() {
    var texto = $('#txtBuscarPedido').val();
    var estado = null;
    for(var i=0 ; i < $('#myTab').children().length ; i++){
        if( $($('#myTab').children()[i]).hasClass("active") ){
            estado = $($('#myTab').children()[i]).children().children().prop('id').split('-tab-cantidad')[0];
        }
    }
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
        }
    }).done(function (response){
        var tr = '';
        for(var i=0 ; i<response.length ;i++){
            var descargar = rutas.descDoc;
            descargar = descargar.replace(':id',response[i].id);
            tr+='<tr>'+
                    '<th scope="row">'+(i+1)+'</th>'+
                    '<td>'+response[i].nombre+'</td>'+
                    '<td>'+getReadableFileSizeString(response[i].size)+'</td>'+
                    '<td><a href="'+descargar+'" class="btn btn-success-custom" title="Descargar '+response[i].nombre+'"><i class="fa fa-download"></i></a></td>'+
                '</tr>';
        }
        $('#tbodyDoc').empty();
        $('#tbodyDoc').append(tr);
        $('#modalDocumentos').modal('show');
    });

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


                $('#btnCompletarSalida').remove();
                $('#btnCompletarPedido').remove();

        }

        $('#accordionSalidaItems').append(
            panelSalida
        );

        $('#verSalidasPedidoModal').modal('show');
    });
}