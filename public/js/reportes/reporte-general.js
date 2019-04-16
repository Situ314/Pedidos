/**
 * Created by carteaga on 17/11/2018.
 */
var verificacion = "";
var verifiAut = "";
$( document ).ready(function(){
    $(".js-placeholder-single").select2({
        allowClear: true,
        placeholder: "Seleccione ...",
        width: '100%'
    }).val('0').trigger('change');

    filtrar();
});

$(".js-placeholder-single").select2({
    allowClear: true,
    placeholder: "Seleccione ...",
    width: '100%'
}).val('0').trigger('change');

function filtrar(){

    // $(".js-placeholder-single").select2({
    //     allowClear: true,
    //     placeholder: "Seleccione ...",
    //     width: '100%'
    // }).val('0').trigger('change');

    var empresa = $("#empresa-select").val();
    var usuario = $("#usuario-select").val();
    var estado = $("#estado-select").val();
    var autorizador = $("#autorizador-select").val();
    var responsable = $("#responsable-select").val();

    var categoria = $("#categoria-select").val();
    var item = $("#item-select").val();

    var desde = $("#desde-select").val();
    var hasta = $("#hasta-select").val();
    var desde_entrega = $("#desde-entrega-select").val();
    var hasta_entrega = $("#hasta-entrega-select").val();

    var route = rutas.pedidos;
    var token = rutas.token;

    $.ajax({
        url: rutas.pedidos,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        data:{
            empresa_id: empresa,
            usuario_id: usuario,
            estado_id: estado,
            autorizador_id: autorizador,
            responsable_id: responsable,
            categoria_id: categoria,
            item_id: item,
            desde: desde,
            hasta: hasta,
            desde_entrega: desde_entrega,
            hasta_entrega: hasta_entrega
        },
        dataType: 'JSON',
        beforeSend: function(e){
            $('#contenido-filtro').empty();
            $('#contenido-filtro').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                '<i class="fa fa-spin fa-spinner"></i><strong> Cargando</strong> pedidos...'+
                '</div>');
        }
    }).done(function (response){
        actualizarTablaFiltro(response);
    });
}

function actualizarTablaFiltro(response){
    console.log(response);

    var tags = "";

    var empresa_filtro= $("#empresa-select option:selected").text();
    var estado_filtro= $("#estado-select option:selected").text();
    var usuario_filtro= $("#usuario-select option:selected").text();
    var autorizador_filtro= $("#autorizador-select option:selected").text();
    var responsable_filtro= $("#responsable-select option:selected").text();
    var categoria_filtro= $("#categoria-select option:selected").text();
    var item_filtro= $("#item-select option:selected").text();

    var desde_filtro = $("#desde-select").val();
    var hasta_filtro = $("#hasta-select").val();

    if($("#empresa-select").val() != 0)
        tags += '<span class="label label-primary" style="margin-right: 5px; font-size: 12px"><i class="fa fa-building-o"></i> EMPRESA: '+ empresa_filtro +' </span>';
    if($("#estado-select").val() != 0)
        tags += '<span class="label label-primary" style="margin-right: 5px; font-size: 12px"><i class="fa fa-check-square-o"></i> ESTADO: '+ estado_filtro +' </span>';
    if($("#usuario-select").val() != 0)
        tags += '<span class="label label-success" style="margin-right: 5px; font-size: 12px"><i class="fa fa-user"></i> SOLICITANTE: '+ usuario_filtro +' </span>';
     if($("#autorizador-select").val() != 0)
        tags += '<span class="label label-success" style="margin-right: 5px; font-size: 12px"><i class="fa fa-user-secret"></i> AUTORIZADOR: '+ autorizador_filtro +' </span>';
    if($("#responsable-select").val() != 0)
        tags += '<span class="label label-success" style="margin-right: 5px; font-size: 12px"><i class="fa fa-users"></i> RESPONSABLE: '+ responsable_filtro +' </span>';
    if($("#categoria-select").val() != 0)
        tags += '<span class="label label-info" style="margin-right: 5px; font-size: 12px"><i class="fa fa-shopping-cart"></i> CATEGORÍA: '+ categoria_filtro +' </span>';
    if($("#item-select").val() != 0)
        tags += '<span class="label label-info" style="margin-right: 5px; font-size: 12px"><i class="fa fa-shopping-basket"></i> ITEM: '+ item_filtro +' </span>';

    if($("#desde-select").val() != "")
        tags += '<span class="label label-default" style="margin-right: 5px; font-size: 12px"><i class="fa fa-calendar"></i> DESDE FECHA: '+ desde_filtro +' </span>';
    if($("#hasta-select").val() != "")
        tags += '<span class="label label-default" style="margin-right: 5px; font-size: 12px"><i class="fa fa-calendar"></i> HASTA FECHA: '+ hasta_filtro +' </span>';


    var head = "";
    var body = "";
    var table = "";

    if(response.pedidos.length!=0){

        head += '<table class="table table-striped jambo_table bulk_action"><thead>\n' +
            '      <tr>\n' +
            '       <th style="color: white">#</th>\n' +
            '       <th style="color: white">Código</th>\n' +
            '       <th style="color: white">Empresa</th>\n' +
            '       <th style="color: white">Proyecto</th>\n' +
            '       <th style="color: white">Solicitante</th>\n' +
            '       <th style="color: white">Asignado a:</th>\n' +
            '       <th style="color: white">Creado en:</th>\n' +
            '       <th style="color: white">Estado</th>\n' +
            '       <th style="color: white">Opciones</th>\n' +
            '      </tr>\n' +
            '     </thead>\n' +
            '     <tbody>';
        for(var i=0;i<response.pedidos.length;i++){

            var label="";
            var icon="";

            var responsable ="";

            if(response.pedidos[i].asignados_nombres_with_trashed.length > 0){
                responsable = response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.nombres+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_1+' '+response.pedidos[i].asignados_nombres_with_trashed[response.pedidos[i].asignados_nombres_with_trashed.length - 1].empleado_nombres.apellido_2;
            }
            else{
                responsable = '<span class="label label-primary">SIN RESPONSABLE</span>';
            }

            if(response.pedidos[i].estados_pedido_detalle.length > 0){
                var estado = response.pedidos[i].estados_pedido_detalle[response.pedidos[i].estados_pedido_detalle.length - 1].estado.nombre;
                var estado_id = response.pedidos[i].estados_pedido_detalle[response.pedidos[i].estados_pedido_detalle.length - 1].estado_id;
                switch(Number(estado_id)) {
                    case 1:
                        label = 'label-info';
                        break;
                    case 2:
                        label = 'label-primary';
                        break;
                    case 3:
                        label = 'label-info';
                        icon ='fa-user';
                        break;
                    case 4:
                        label = 'label-warning';
                        break;
                    case 5:
                        label = 'label-warning';
                        icon ='fa-paper-plane';
                        break;
                    case 6:
                        label = 'label-warning';
                        icon ='fa-eye';
                        break;
                    case 7:
                        label = 'label-danger';
                        break;
                    case 8:
                        label = 'label-success';
                        icon ='fa-check';
                        break;
                    case 9:
                        label = 'label-warning';
                        icon ='fa-clock-o';
                        break;
                }
            }else{
                label = 'label-default';
                var estado = 'SIN ESTADO';
            }

            var opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response.pedidos[i].id+');" title="Ver lista '+response.pedidos[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response.pedidos[i].id+');"><i class="fa fa-header"></i></button>';

            body+='<tr>\n' +
                '    <td>'+(i+1)+'</td>\n' +
                '    <td>'+response.pedidos[i].codigo+'</td>\n' +
                '    <td>'+response.pedidos[i].proyecto_empresa.empresa.nombre+'</td>\n' +
                '    <td>'+response.pedidos[i].proyecto_empresa.nombre+'</td>\n' +
                '    <td>'+response.pedidos[i].solicitante_empleado.empleado.nombres+' '+response.pedidos[i].solicitante_empleado.empleado.apellido_1+' '+response.pedidos[i].solicitante_empleado.empleado.apellido_2+'</td>\n' +
                '    <td>'+responsable+'</td>\n' +
                '    <td>'+response.pedidos[i].created_at+'</td>\n' +
                '    <td>'+'<span class="label '+label+'"><i class="fa '+icon+'"></i> '+estado+'</span>'+'</td>\n' +
                '    <td <div class="btn-group" role="group">'+opciones+'</div></td>\n' +
                '  </tr>';
        }

        table=
            head+
            body+
            '</tbody>'+
            '</table>';
    }else{
        table += '<div class="alert alert-info alert-dismissible fade in" role="alert">'+
            '<strong><i class="fa fa-check"></i></strong> No hay registros que cumplan con los filtros solicitados'+
            '</div>';
    }

    $('#contenido-filtro').empty();
    $('#contenido-filtro').append(table);

    var titulo_asignados = 'Resultado <strong>('+response.pedidos.length+' Registros Obtenidos)</strong>';
    $('#titulo-contador').empty();
    $('#titulo-contador').append(titulo_asignados);

    $('#tags-filtro').empty();
    $('#tags-filtro').append(tags);
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

function excel(){

    // $(".js-placeholder-single").select2({
    //     allowClear: true,
    //     placeholder: "Seleccione ...",
    //     width: '100%'
    // }).val('0').trigger('change');

    var empresa = $("#empresa-select").val();
    var usuario = $("#usuario-select").val();
    var estado = $("#estado-select").val();
    var autorizador = $("#autorizador-select").val();
    var responsable = $("#responsable-select").val();

    var categoria = $("#categoria-select").val();
    var item = $("#item-select").val();

    var desde = $("#desde-select").val();
    var hasta = $("#hasta-select").val();
    var desde_entrega = $("#desde-entrega-select").val();
    var hasta_entrega = $("#hasta-entrega-select").val();

    var route = rutas.pedidos;
    var token = rutas.token;

    $.ajax({
        url: rutas.excel,
        headers: {'X-CSRF-TOKEN': token, 'Content-Type': 'application/vnd.ms-excel'},
        type: 'GET',
        data:{
            empresa_id: empresa,
            usuario_id: usuario,
            estado_id: estado,
            autorizador_id: autorizador,
            responsable_id: responsable,
            $categoria_id: categoria,
            $item_id: item,
            desde: desde,
            hasta: hasta,
            desde_entrega: desde_entrega,
            hasta_entrega: hasta_entrega
        },
        dataType: 'JSON',
        beforeSend: function(e){
             $('#pop-excel').empty();
            $('#pop-excel').append('<div class="alert alert-warning alert-dismissible fade in" role="alert">'+
                '<i class="fa fa-spin fa-spinner"></i><strong> Generando</strong> archivo Excel...'+
                '</div>');
        }
    }).done(function (response){
        console.log(response);
        if(response.url != '0'){
            window.location.href = response.url;
            $('#pop-excel').empty();
            $('#pop-excel').append('<div class="alert alert-info alert-dismissible fade in" role="alert">\n' +
                '         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>\n' +
                '        </button>\n' +
                '        <strong>Archivo Excel generado satisfactoriamente</strong> Su archivo se descargará en breve.\n' +
                '        </div>');
        }else{
            $('#pop-excel').empty();
            $('#pop-excel').append('<div class="alert alert-danger alert-dismissible fade in" role="alert">\n' +
                '         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>\n' +
                '        </button>\n' +
                '        La consulta no generó ningún registro. <strong>No se generó el archivo Excel</strong>\n' +
                '        </div>');
        }


    });
}