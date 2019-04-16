 switch (parseInt(variables.uR)){
                case 1://R
                case 2://AD

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
                        case 9:
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
                    if(estado == 4 || estado == 5|| estado ==8)
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].salidas_almacen[0].num_solicitud+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response [i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
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
                        case 9:
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

                    body+='<tr><th scope="row">'+(i+1)+'</th>' +
                        '<td>'+response[i].codigo+'</td>' +
                        '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                        '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
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
                                    '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
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
                                            '<a href="'+rutas.salidasEdit.replace(':id',response[i].id)+'" class="btn btn-success-custom" title="Completar pedido '+response[i].codigo+'"><i class="fa fa-check-square-o"></i></a>'+
                                            '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                                        break;
                                }
                            }else{
                                opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                    '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            }
                            break;
                    }
                    if(response[i].documentos.length > 0){
                        opciones += '<button type="button" class="btn btn-primary-custom" onclick="verDocumentos('+response[i].id+');" title="Ver documentos '+response[i].codigo+'"><i class="fa fa-book"></i></button>';
                    }
                    //************************************

                    //************************************CUERPO
                    if(estado == 4 || estado == 5|| estado ==8)
                       body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].salidas_almacen[0].num_solicitud+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
                    else
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
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
                            opciones = '<button type="button" class="btn btn-info-custom" onclick="verItems('+response[i].id+');" title="Ver lista '+response[i].codigo+'"><i class="fa fa-list-alt"></i></button>' +
                                '<button type="button" class="btn btn-warning-custom" onclick="verSalidasFinalizado('+response[i].id+');" title="Ver salidas del pedido '+response[i].codigo+'"><i class="fa fa-sign-out"></i></button>'+
                                '<button type="button" class="btn btn-default" title="Ver historial" onclick="verProgreso('+response[i].id+');"><i class="fa fa-header"></i></button>';
                            break;
                        case 9:
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

                    if(estado == 4 || estado == 5|| estado ==8)
                       body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].salidas_almacen[0].num_solicitud+'</td>' +
                            '<td>'+proyecto+'</td>' +
                            '<td>'+empresa+'</td>' +
                            '<td>'+response[i].solicitante_empleado.empleado.nombres+' '+response[i].solicitante_empleado.empleado.apellido_1+' '+response[i].solicitante_empleado.empleado.apellido_2+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
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
                        case 9:
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
                    if(estado == 4 || estado == 5|| estado ==8)
                        body+='<tr><th scope="row">'+(i+1)+'</th>' +
                            '<td>'+response[i].codigo+'</td>' +
                            '<td>'+response[i].salidas_almacen[0].num_solicitud+'</td>' +
                            '<td>'+response[i].proyecto_empresa.empresa.nombre+'</td>' +
                            '<td>'+response[i].proyecto_empresa.nombre+'</td>' +
                            '<td>'+responsable+'</td>' +
                            '<td>'+response[i].created_at+'</td>' +
                            '<td><div class="btn-group" role="group">' +
                            opciones+
                            '</div></td>'+
                            '</tr>';
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
            }
        }