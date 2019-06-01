<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
//    if(\Illuminate\Support\Facades\Auth::check()){
//        return redirect('dash');
//    }else{
//        return redirect('login');
//    }
});

Route::get('/', function () {
   // return view('welcome');
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect('dash');
    }else{
        return redirect('login');
    }
});

Route::get('/buscar',[
    'uses'=>'PedidosController@getPedido',
    'as'=>'pedidos.buscar'
]);

Route::get('/buscarItem',[
    'uses'=>'PedidosController@getPedidoItem',
    'as'=>'pedidos.buscaritem'
]);

Auth::routes();

Route::group(['middleware' => 'auth'],  function (){
    Route::get('/dash', [
        'uses'=> 'HomeController@index',
        'as'=> 'dash.index'
    ]);

    Route::post('/dash/{inicio}/{fin}/fechas',[
        'uses'=>'HomeController@postPedidosGroupFecha',
        'as'=>'dash.fecha'
    ]);

    Route::post('/dash/misauts',[
        'uses'=>'HomeController@postMisAutorizadores',
        'as'=>'dash.mis.aut'
    ]);

    //******************************************************PEDIDOS
    Route::resource('/pedidos', 'PedidosController');

    Route::post('post.pedidos',[
        'uses'=>'PedidosController@postPedidos',
        'as'=>'pedidos.estados'
    ]);

    Route::post('post.pedidos.gestion',[
        'uses'=>'PedidosController@postPedidosGestion',
        'as'=>'pedidos.estados.gestion'
    ]);

    Route::post('post.pedidos.autorizador',[
        'uses'=>'PedidosController@postPedidosAutorizador',
        'as'=>'pedidos.estados.autorizador'
    ]);

    Route::get('post.2018',[
        'uses'=>'PedidosController@index_2018',
        'as'=>'pedidos.index2k18'
    ]);

    Route::get('pedidos.index.aut',[
        'uses'=>'PedidosController@index_aut',
        'as'=>'pedidos.index.aut'
    ]);

    Route::post('post.pedidos.cantidad',[
        'uses'=>'PedidosController@postCantidad',
        'as'=>'pedidos.cantidad'
    ]);

    Route::post('post.pedidos.cantidad.aut',[
        'uses'=>'PedidosController@postCantidadAut',
        'as'=>'pedidos.cantidad.aut'
    ]);

    Route::post('post.pedidos.item',[
        'uses'=>'PedidosController@postItemsPedido',
        'as'=>'pedidos.items'
    ]);

    Route::post('post.pedidos.estados',[
        'uses'=>'PedidosController@postEstadosPedido',
        'as'=>'pedidos.progreso'
    ]);

    Route::post('post.pedidos.buscar',[
        'uses'=>'PedidosController@buscarPedido',
        'as'=>'pedidos.buscar'
    ]);

    Route::post('post.pedidos.buscarItem',[
        'uses'=>'PedidosController@buscarPedidoItem',
        'as'=>'pedidos.buscaritem'
    ]);

    Route::post('post.pedidos.responsable',[
        'uses'=>'PedidosController@postPedidosXResponsable',
        'as'=>'pedidos.pedidosxresp'
    ]);

    Route::get('/imprimir/{id}/imprimir-sol',[
        'uses'=>'PedidosController@getPedidoImprimirItemsSolicitados',
        'as'=>'impimir.pedido.solicitados'
    ]);

    Route::get('/imprimir/{id}/imprimir-sol-tic',[
        'uses'=>'PedidosController@getPedidoImprimirItemsSolicitadosTic',
        'as'=>'impimir.pedido.solicitados.tic'
    ]);

    Route::get('/imprimir/{id}/imprimir-ent',[
        'uses'=>'PedidosController@getPedidoImprimirItemsEntregados',
        'as'=>'impimir.pedido.entregados'
    ]);

    Route::get('/dashboard/responsables',[
        'uses'=>'PedidosController@getDashboardResponsable',
        'as'=>'pedidos.dashboardR'
    ]);

    Route::get('/dashboard/asignador',[
        'uses'=>'PedidosController@getDashboardAsignador',
        'as'=>'pedidos.asignador'
    ]);

    Route::get('/informe/correo',[
        'uses'=>'PedidosController@enviarCorreo',
        'as'=>'correo.responsable.informe'
    ]);

    Route::get('/informe/correo/responsable',[
        'uses'=>'PedidosController@enviarCorreoResponsable',
        'as'=>'correo.responsable.informe.personal'
    ]);
    //******************************************************

    //******************************************************ASIGNADOR
    Route::resource('/asignaciones','AsignacionesController');

    Route::get('/asignaciones/{id}/tic',[
        'uses'=>'AsignacionesController@edit_tic',
        'as'=>'asignaciones.edit.tic'
    ]);
    //******************************************************VERIFICACION
    Route::resource('/verificacion','VerificacionController');

    //******************************************************AUTORIZADOR
    Route::resource('/autorizador','AutorizadorController');

    Route::get('/get.cambiarUsu/{usu}/{opcion}',[
        'uses'=>'AutorizadorController@getCambiarRango',
        'as'=>'autorizador.cambiar'
    ]);
    //******************************************************

    //******************************************************REVISOR
    Route::resource('/revisor','RevisorController');

    Route::get('/get.cambiarUsu/{usu}/{opcion}',[
        'uses'=>'AutorizadorController@getCambiarRango',
        'as'=>'autorizador.cambiar'
    ]);
    //******************************************************

    //******************************************************DEVOLUCION
    Route::resource('/devolucion','DevolucionesController');

    Route::post('/devolucion.Tic/',[
        'uses'=>'DevolucionesController@updateTic',
        'as'=>'devolucion.tic'
    ]);

    Route::post('/devolucion.Tepco/',[
        'uses'=>'DevolucionesController@updateTepco',
        'as'=>'devolucion.tepco'
    ]);
    //******************************************************RESPONSABLE
    Route::resource('/responsable','ResponsableController');

    Route::post('/post.responsableProceso',[
        'uses'=>'ResponsableController@postProceso',
        'as'=>'pedidos.proceso'
    ]);

    Route::put('/responsable.update.tic/{id}',[
        'uses'=>'ResponsableController@update_tic',
        'as'=>'responsable.update.tic'
    ]);

    Route::get('/responsable/{id}/completar',[
        'uses'=>'ResponsableController@getCompletarPedido',
        'as'=>'responsable.completar'
    ]);

    Route::get('/responsable/{id}/completarTic',[
        'uses'=>'ResponsableController@getCompletarPedidoTic',
        'as'=>'responsable.completarTic'
    ]);
    //******************************************************

    //******************************************************ITEMS
    Route::post('/post.items.buscar',[
        'uses'=>'ItemsController@buscarItem',
        'as'=>'buscar.item',
    ]);

    //******************************************************SALIDAS DE ALMACEN
    Route::resource('/salidas','SalidaAlmacenController');

    Route::post('/post.max.sal',[
        'uses'=>'SalidaAlmacenController@postUltimoNumeroSalida',
        'as'=> 'salida.id.max'
    ]);

    Route::post('/post.salida',[
        'uses'=>'SalidaAlmacenController@postSalidaItems',
        'as'=>'salida.alm'
    ]);

    Route::post('/post.salida.tic',[
        'uses'=>'SalidaAlmacenController@postSalidaItemsTic',
        'as'=>'salida.alm.tic'
    ]);

    Route::get('/pdfSalidaAlmacen/{id}',[
        'uses'=>'SalidaAlmacenController@pdfSalida',
        'as'=>'salidas.pdf'
    ]);
    //******************************************************

    //******************************************************DOCUMENTOS - ARCHIVOS SUBIDOS
    Route::resource('/documento','DocumentoController');
    Route::post('/post.doc.pedido',[
        'uses'=>'DocumentoController@postDocs',
        'as'=>'post.docs'
    ]);
    Route::get('documento/{id}/descargar', [
        'uses' => 'DocumentoController@getDocumento',
        'as'=> 'doc.descargar'
    ]);
    Route::get('documento/{id}/archivo', [
        'uses'=>'DocumentoController@getFile',
        'as'=>'doc.get'
    ]);
    //******************************************************

    //******************************************************ADMINISTRACION
    //******************************************************USUARIOS
    Route::resource('/admin-usuarios','UsersController');
    Route::get('/admin-usuarios/{id}/restaurar',[
        'uses'=> 'UsersController@restore',
        'as'=> 'usuario.restore'
    ]);
    Route::put('/admin-usuarios/{id}/cambiarPassword',[
        'uses'=> 'UsersController@updatePassword',
        'as'=> 'admin-usuario.update.password'
    ]);
    //******************************************************AUTORIZADORES
    Route::resource('/admin-autorizadores','AdminAutorizadoresController');
    Route::get('/admin-autorizadores/{id}/equipo',[
        'uses'=>'AdminAutorizadoresController@getMisSolicitantes',
        'as'=>'admin-autorizadores.equipo'
    ]);
    Route::match(['put', 'patch'], '/admin-autorizadores/{id}/autorizadores', [
        'uses'=>'AdminAutorizadoresController@updateAutorizadores',
        'as'=>'update.autorizadores'
    ]);
    Route::get('/admin-autorizadores/{id}/{opcion}/cambiarRol',[
        'uses'=>'AdminAutorizadoresController@getCambiarRol',
        'as'=>'admin-autorizadores.cambiar_rol'
    ]);
    Route::post('/post.autorizadores/{id}',[
        'uses'=>'AdminAutorizadoresController@postAutorizadores',
        'as'=>'post.autorizadores'
    ]);
    //******************************************************

    //******************************************************PARÁMETROS
    Route::resource('/parametros','ParametroController');
    //******************************************************CAMBIO DE CONTRASEÑA
    Route::resource('/cambiar-pass','UpdatePasswordController');
    //******************************************************

    //******************************************************CAMBIO DE CONTRASEÑA
    Route::resource('/responsable-entrega','ResponsableEntregaController');
    //******************************************************

    //******************************************************REPORTES
    Route::get('/reporte/general',[
        'uses'=>'ReporteController@getGeneral',
        'as'=>'reporte.general'
    ]);

    Route::get('/reporte/items',[
        'uses'=>'ReporteController@getItems',
        'as'=>'reporte.items'
    ]);

    Route::post('/reporte/general/filtrado',[
        'uses'=>'ReporteController@postFiltrado',
        'as'=>'reporte.filtrado'
    ]);

    Route::post('/reporte/general/filtradoItems',[
        'uses'=>'ReporteController@postFiltradoItems',
        'as'=>'reporte.filtrado.items'
    ]);

    Route::get('/reporte/general/excel',[
        'uses'=>'ExcelController@downloadExcel',
        'as'=>'reporte.excel'
    ]);

    Route::get('/reporte/items/excel',[
        'uses'=>'ExcelController@downloadExcelItems',
        'as'=>'reporte.excel.items'
    ]);

    Route::get('/pdfPedidoResponsable/{id}',[
        'uses'=>'PedidosController@pdfInforme',
        'as'=>'imprimir.responsable.informe'
    ]);

    Route::get('/ss',function (){
        echo ini_get('max_execution_time');
    });
});
////Route::get('/home', 'HomeController@index');
///*Route::get('/batch',function (){
//    system("cmd /c C:\Users\djauregui\Desktop\pr.bat");
//    system("./bin/winexe -U Administrador%Password //172.20.1.163 'D:\CuboBatchs\CI_batch.bat'");
//});
