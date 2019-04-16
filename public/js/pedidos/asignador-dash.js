/**
 * Created by djauregui on 8/12/2017.
 */
var verificacion = "";
var verifiAut = "";
$( document ).ready(function(){

    moment.locale("es");
    $(".js-placeholder-single").select2({
        allowClear: true,
        // placeholder: "Seleccione ...",
        width: '100%'
    }).val('0').trigger('change');

    getPedidosResponsable();

});

$('.js-placeholder-single').select2({
    allowClear: true,
    // placeholder: "Seleccione...",
    width: '100%'
}).val('').trigger('change');

function getPedidosResponsable() {
    //responsable_id
    var responsable = $('#responsables-select').val();
    var token = rutas.token;

        $.ajax({
            url: rutas.pedidos,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            data:{
                responsable_id: responsable
            },
            dataType: 'JSON',
            beforeSend: function(e){
                $('#contenido').empty();
                $('#contenido').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                    '<i class="fa fa-spin fa-spinner"></i><strong> Cargando</strong> pedidos...'+
                    '</div>');
            }
        }).done(function (response){

            actualizarTablas(response, responsable);
        });
}

function actualizarTablas(response, responsable) {

    $('#contenido').empty();
    moment.locale("es");
    console.log(response);


    var head = "";
    var body = "";
    var table = "";
    var head_pendientes = "";
    var body_pendientes= "";
    var table_pendientes = "";
    var head_despachados = "";
    var body_despachados = "";
    var table_despachados = "";
    var head_espera = "";
    var body_espera = "";
    var table_espera = "";
   // if(response.length!=0) {
        head += '<table class="table table-striped jambo_table bulk_action"><thead>\n' +
            '      <tr>\n' +
            '       <th style="color: white">Código</th>\n' +
            '       <th style="color: white">Empresa</th>\n' +
            '       <th style="color: white">Solicitante</th>\n' +
            '       <th style="color: white">Responsable</th>\n' +
            '       <th style="color: white">Creado</th>\n' +
            '       <th></th>\n' +
            '       <th style="color: white">Opciones</th>\n' +
            '       <th style="color: white">Acciones</th>\n' +
            '      </tr>\n' +
            '     </thead>\n' +
            '     <tbody>';

        for(var i=0;i<response.pedidos.length;i++){

            var label="";

            var date1 = new Date(response.pedidos[i].created_at);
            var date2 = new Date();
            var timeDiff = Math.abs(date2.getTime() - date1.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

            label = 'label-success';
            if(diffDays > 7){
                label = 'label-warning';
            }if(diffDays > 15){
                label = 'label-warning';
            }if(diffDays > 30){
                label = 'label-danger';
            }

            var nombre_responsable = response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2;
            var diff = moment(date1).fromNow();
            var acciones = '<button type="button" class="btn btn-default" title="Enviar correo" onclick="abrirModalEmailResponsable('+response.pedidos[i].id+','+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.id+',\''+response.pedidos[i].codigo+'\',\''+nombre_responsable+'\');"><i class="fa fa-envelope"></i></button>';

            var opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response.pedidos[i].id+');" title="Ver lista '+response.pedidos[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response.pedidos[i].id+');"><i class="fa fa-header"></i></button>';

            moment.locale('es');
            console.log(moment.locale());
            body+='<tr>\n' +
                '    <td>'+response.pedidos[i].codigo+'</td>\n' +
                '    <td>'+response.pedidos[i].proyecto_empresa.empresa.nombre+'</td>\n' +
                '    <td>'+response.pedidos[i].solicitante_empleado.empleado.nombres+' '+response.pedidos[i].solicitante_empleado.empleado.apellido_1+' '+response.pedidos[i].solicitante_empleado.empleado.apellido_2+'</td>\n' +
                '    <td>'+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2+'</td>\n' +
                '    <td>'+response.pedidos[i].created_at+'</td>\n' +
                '    <td>\n' +
                '      <span class="label '+label+'">'+moment(date1).fromNow()+'</span>\n' +
                '   </td>\n' +
                '    <td><div class="btn-group" role="group">'+opciones+'</div></td>\n' +
                '    <td><div class="btn-group" role="group">'+acciones+'</div></td>\n' +
                '  </tr>';

                console.log(body);
        }

        if(response.pedidos.length > 0){
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


        // $('#print-asignados').attr('onClick','printInforme('+JSON.stringify(response.pedidos)+')');

        var imp_inf = rutas.impInf;
        var enviar = responsable+'-1';
        $('#print-asignados').prop('href',imp_inf.replace(':id',enviar));
        $('#email-asignados').attr('onclick','abrirModalEmail(1)');
        var enviar_todo = responsable+'-0';
        $('#print-todo').prop('href',imp_inf.replace(':id',enviar_todo));

        $('#table-pedido').empty();
        $('#table-pedido').append(table);

        var titulo_asignados = 'Pedidos Asignados ('+response.pedidos.length+')';
        $('#titulo-asignados').empty();
        $('#titulo-asignados').append(titulo_asignados);
    //PEDIDOS EN ESPERA
    head_espera += '<table class="table table-striped jambo_table bulk_action"><thead>\n' +
        '      <tr>\n' +
        '       <th style="color: white">Código</th>\n' +
        '       <th style="color: white">Empresa</th>\n' +
        '       <th style="color: white">Solicitante</th>\n' +
        '       <th style="color: white">Responsable</th>\n' +
        '       <th style="color: white">Creado</th>\n' +
        '       <th></th>\n' +
        '       <th style="color: white">Opciones</th>\n' +
        '       <th style="color: white">Acciones</th>\n' +
        '      </tr>\n' +
        '     </thead>\n' +
        '     <tbody>';

    for(var i=0;i<response.pedidos_espera.length;i++){

        var label="";

        var date1 = new Date(response.pedidos_espera[i].created_at);
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        label = 'label-success';
        if(diffDays > 7){
            label = 'label-warning';
        }if(diffDays > 15){
            label = 'label-warning';
        }if(diffDays > 30){
            label = 'label-danger';
        }

        var nombre_responsable = response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2;

        var acciones = '<button type="button" class="btn btn-default" title="Enviar correo" onclick="abrirModalEmailResponsable('+response.pedidos_espera[i].id+','+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.id+',\''+response.pedidos_espera[i].codigo+'\',\''+nombre_responsable+'\');"><i class="fa fa-envelope"></i></button>';

        var opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response.pedidos_espera[i].id+');" title="Ver lista '+response.pedidos_espera[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response.pedidos_espera[i].id+');"><i class="fa fa-header"></i></button>';

        var diff = moment(date1).fromNow();
        moment.locale('es');
        console.log(moment.locale());
        body_espera+='<tr>\n' +
            '    <td>'+response.pedidos_espera[i].codigo+'</td>\n' +
            '    <td>'+response.pedidos_espera[i].proyecto_empresa.empresa.nombre+'</td>\n' +
            '    <td>'+response.pedidos_espera[i].solicitante_empleado.empleado.nombres+' '+response.pedidos_espera[i].solicitante_empleado.empleado.apellido_1+' '+response.pedidos_espera[i].solicitante_empleado.empleado.apellido_2+'</td>\n' +
            '    <td>'+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_espera[i].asignados_nombres_with_trashed[response.pedidos_espera[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2+'</td>\n' +
            '    <td>'+response.pedidos_espera[i].created_at+'</td>\n' +
            '    <td>\n' +
            '      <span class="label '+label+'">'+moment(date1).fromNow()+'</span>\n' +
        '   </td>\n' +
            '    <td><div class="btn-group" role="group">'+opciones+'</div></td>\n' +
            '    <td><div class="btn-group" role="group">'+acciones+'</div></td>\n' +
        '  </tr>';
    }

    if(response.pedidos_espera.length > 0){
        table_espera=
            head_espera+
            body_espera+
            '</tbody>'+
            '</table>';
    }else{
        table_espera += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
            '</div>';
    }

    var enviar = responsable+'-4';
    $('#print-espera').prop('href',imp_inf.replace(':id',enviar));
    $('#email-espera').attr('onclick','abrirModalEmail(4)');

    $('#table-pedido-espera').empty();
    $('#table-pedido-espera').append(table_espera);

    var titulo_espera = 'Pedidos en Espera ('+response.pedidos_espera.length+')';
    $('#titulo-espera').empty();
    $('#titulo-espera').append(titulo_espera);

    //PEDIDOS PENDIENTES
    head_pendientes += '<table class="table table-striped jambo_table bulk_action"><thead>\n' +
        '      <tr>\n' +
        '       <th style="color: white">Código</th>\n' +
        '       <th style="color: white">Empresa</th>\n' +
        '       <th style="color: white">Solicitante</th>\n' +
        '       <th style="color: white">Solicitud</th>\n' +
        '       <th style="color: white">Responsable</th>\n' +
        '       <th style="color: white">Creado</th>\n' +
        '       <th></th>\n' +
        '       <th style="color: white">Opciones</th>\n' +
        '       <th style="color: white">Acciones</th>\n' +
        '      </tr>\n' +
        '     </thead>\n' +
        '     <tbody>';

    for(var i=0;i<response.pedidos_parciales.length;i++){

        var label="";

        var date1 = new Date(response.pedidos_parciales[i].created_at);
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        label = 'label-success';
        if(diffDays > 7){
            label = 'label-warning';
        }if(diffDays > 15){
            label = 'label-warning';
        }if(diffDays > 30){
            label = 'label-danger';
        }

        var nombre_responsable = response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2;

        var acciones = '<button type="button" class="btn btn-default" title="Enviar correo" onclick="abrirModalEmailResponsable('+response.pedidos_parciales[i].id+','+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.id+',\''+response.pedidos_parciales[i].codigo+'\',\''+nombre_responsable+'\');"><i class="fa fa-envelope"></i></button>';

        var opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response.pedidos_parciales[i].id+');" title="Ver lista '+response.pedidos_parciales[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response.pedidos_parciales[i].id+');"><i class="fa fa-header"></i></button>';

        var diff = moment(date1).fromNow();
        moment.locale('es');
        console.log(moment.locale());
        body_pendientes+='<tr>\n' +
            '    <td>'+response.pedidos_parciales[i].codigo+'</td>\n' +
            '    <td>'+response.pedidos_parciales[i].proyecto_empresa.empresa.nombre+'</td>\n' +
            '    <td>'+response.pedidos_parciales[i].solicitante_empleado.empleado.nombres+' '+response.pedidos_parciales[i].solicitante_empleado.empleado.apellido_1+' '+response.pedidos_parciales[i].solicitante_empleado.empleado.apellido_2+'</td>\n' +
            '    <td> # '+response.pedidos_parciales[i].salidas_almacen[0].num_solicitud+'</td>\n' +
            '    <td>'+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_parciales[i].asignados_nombres_with_trashed[response.pedidos_parciales[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2+'</td>\n' +
            '    <td>'+response.pedidos_parciales[i].created_at+'</td>\n' +
            '    <td>\n' +
            '      <span class="label '+label+'">'+moment(date1).fromNow()+'</span>\n' +
        '   </td>\n' +
            '    <td><div class="btn-group" role="group">'+opciones+'</div></td>\n' +
            '    <td><div class="btn-group" role="group">'+acciones+'</div></td>\n' +
        '  </tr>';
    }

    if(response.pedidos_parciales.length > 0){
        table_pendientes=
            head_pendientes+
            body_pendientes+
            '</tbody>'+
            '</table>';
    }else{
        table_pendientes += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
            '</div>';
    }


    $('#table-pedido-parciales').empty();
    $('#table-pedido-parciales').append(table_pendientes);

    var enviar = responsable+'-2';
    $('#print-pendientes').prop('href',imp_inf.replace(':id',enviar));
    $('#email-pendientes').attr('onclick','abrirModalEmail(2)');

    var titulo_parciales = 'Pedidos Parciales Pendientes ('+response.pedidos_parciales.length+')';
    $('#titulo-parciales').empty();
    $('#titulo-parciales').append(titulo_parciales);
    //PEDIDOS DESPACHADOS
    head_despachados += '<table class="table table-striped jambo_table bulk_action"><thead>\n' +
        '      <tr>\n' +
        '       <th style="color: white">Código</th>\n' +
        '       <th style="color: white">Empresa</th>\n' +
        '       <th style="color: white">Solicitante</th>\n' +
        '       <th style="color: white">Solicitud</th>\n' +
        '       <th style="color: white">Responsable</th>\n' +
        '       <th style="color: white">Creado</th>\n' +
        '       <th></th>\n' +
        '       <th style="color: white">Opciones</th>\n' +
        '       <th style="color: white">Acciones</th>\n' +
        '      </tr>\n' +
        '     </thead>\n' +
        '     <tbody>';

    for(var i=0;i<response.pedidos_despachados.length;i++){

        var label="";

        var date1 = new Date(response.pedidos_despachados[i].created_at);
        var date2 = new Date();
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        label = 'label-success';
        if(diffDays > 7){
            label = 'label-warning';
        }if(diffDays > 15){
            label = 'label-warning';
        }if(diffDays > 30){
            label = 'label-danger';
        }

        var nombre_responsable = response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2;

        var acciones = '<button type="button" class="btn btn-default" title="Enviar correo" onclick="abrirModalEmailResponsable('+response.pedidos_despachados[i].id+','+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.id+',\''+response.pedidos_despachados[i].codigo+'\',\''+nombre_responsable+'\');"><i class="fa fa-envelope"></i></button>';

        var opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response.pedidos_despachados[i].id+');" title="Ver lista '+response.pedidos_despachados[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response.pedidos_despachados[i].id+');"><i class="fa fa-header"></i></button>';

        var diff = moment(date1).fromNow();
        moment.locale('es');
        console.log(moment.locale());
        body_despachados+='<tr>\n' +
            '    <td>'+response.pedidos_despachados[i].codigo+'</td>\n' +
            '    <td>'+response.pedidos_despachados[i].proyecto_empresa.empresa.nombre+'</td>\n' +
            '    <td>'+response.pedidos_despachados[i].solicitante_empleado.empleado.nombres+' '+response.pedidos_despachados[i].solicitante_empleado.empleado.apellido_1+' '+response.pedidos_despachados[i].solicitante_empleado.empleado.apellido_2+'</td>\n' +
            '    <td> # '+response.pedidos_despachados[i].salidas_almacen[0].num_solicitud+'</td>\n' +
            '    <td>'+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos_despachados[i].asignados_nombres_with_trashed[response.pedidos_despachados[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2+'</td>\n' +
            '    <td>'+response.pedidos_despachados[i].created_at+'</td>\n' +
            '    <td>\n' +
            '      <span class="label '+label+'">'+moment(date1).fromNow()+'</span>\n' +
            '   </td>\n' +
            '    <td><div class="btn-group" role="group">'+opciones+'</div></td>\n' +
            '    <td><div class="btn-group" role="group">'+acciones+'</div></td>\n' +
            '  </tr>';
    }

    if(response.pedidos_despachados.length > 0){
        table_despachados=
            head_despachados+
            body_despachados+
            '</tbody>'+
            '</table>';
    }else{
        table_despachados += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay pedidos en este estado'+
            '</div>';
    }

    $('#table-pedido-despachados').empty();
    $('#table-pedido-despachados').append(table_despachados);

    var enviar = responsable+'-3';
    $('#print-despachados').prop('href',imp_inf.replace(':id',enviar));
    $('#email-despachados').attr('onclick','abrirModalEmail(3)');

    var titulo_despachados = 'Pedidos Despachados ('+response.pedidos_despachados.length+')';
    $('#titulo-despachados').empty();
    $('#titulo-despachados').append(titulo_despachados);
}

function verItems(id) {
    var route = rutas.getItem;
    var token = rutas.token;

    var imp_sol = rutas.impSol;
    var imp_ent = rutas.impEnt;

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
                var entregado = 0;
                for(var j=0;j<response.salidas_almacen.length;j++){
                    for(var k=0;k<response.salidas_almacen[j].salida_items.length;k++){
                        if(response.salidas_almacen[j].salida_items[k].item_pedido_entregado.item_id == response.items_entrega[i].item.id){
                            entregado=entregado+response.salidas_almacen[j].salida_items[k].cantidad;
                        }
                    }
                }

                var labelEntregado = '';
                if(entregado >= response.items_entrega[i].cantidad)
                    labelEntregado = '<label class="label label-success">Completo</label>';
                else{
                    if(entregado == 0)
                        labelEntregado = '<label class="label label-danger">Sin Entrega</label>';
                    else
                        labelEntregado = '<label class="label label-warning">Parcial</label>';
                }

                bodyItemsEntregar += '<tr><th scope="row">'+(i+1)+'</th>' +
                    '<td>'+response.items_entrega[i].item.nombre+'</td>' +
                    '<td>'+response.items_entrega[i].cantidad+'</td>' +
                    '<td>'+labelEntregado+' '+entregado+'</td>' +
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
        }

        $('#panel-body-items-entregado').empty();
        $('#panel-body-items-entregado').append(tableItemsEntregado);

        $('#verItemsPedidoModal').modal('show');

        $('#btnImprimirItemsSolicitados').prop('href',imp_sol.replace(':id',id));
        $('#btnImprimirItemsEntregar').prop('href',imp_ent.replace(':id',id));

    });

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

function abrirModalEmail(tipo){
    var responsable = $('#responsables-select').val();

    $('#responsable').val(responsable);
    $('#tipo').val(tipo);
    $('#enviarEmailModal').modal('show');
}

function abrirModalEmailResponsable(pedido, responsable, codigo, nombre){
    // var responsable = $('#responsables-select').val();

    $('#titulo').text("Enviar correo electrónico Informe Pedido: "+codigo);
    $('#responsable-modal').text("Se enviará un correo electrónico a "+nombre+" indicando los Datos de este pedido.");

    $('#enviar-modal').attr("onClick","enviarEmailPedido("+pedido+","+responsable+")");
    $('#enviarResponsableModal').modal('show');
}

function enviarEmailInforme(){

    var email = $('#email').val();
    var tipo = $('#tipo').val();
    var responsable = $('#responsable').val();
    var mensaje = $('#mensaje').val();
    var nombre = $('#nombre').val();

    var token = rutas.token;
    $.ajax({
        url: rutas.informe,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        data:{
            email: email,
            tipo: tipo,
            responsable: responsable,
            mensaje: mensaje,
            nombre: nombre,
        },
        dataType: 'JSON',
        beforeSend: function(e){
            $('#contenido').empty();
            $('#contenido').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                '<i class="fa fa-spin fa-spinner"></i><strong> Enviando</strong> correo electrónico...'+
                '</div>');
        }
    }).done(function (response){
        $('#contenido').empty();
        $('#contenido').append('<div class="alert alert-success alert-dismissible fade in" role="alert">'+
            '<i class="fa fa-envelope-o"></i><strong> Correo electrónico</strong> enviado exitosamente...'+
            '</div>');
    });
}

function enviarEmailPedido(pedido, responsable){

    var token = rutas.token;
    $.ajax({
        url: rutas.correo,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        data:{
            pedido_id: pedido,
            responsable_id: responsable,
        },
        dataType: 'JSON',
        beforeSend: function(e){
            $('#contenido').empty();
            $('#contenido').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                '<i class="fa fa-spin fa-spinner"></i><strong> Enviando</strong> correo electrónico...'+
                '</div>');
        }
    }).done(function (response){
        $('#contenido').empty();
        $('#contenido').append('<div class="alert alert-success alert-dismissible fade in" role="alert">'+
            '<i class="fa fa-envelope-o"></i><strong> Correo electrónico</strong> enviado exitosamente...'+
            '</div>');
    });
}