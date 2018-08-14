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
//    return view('welcome');
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

Auth::routes();

Route::group(['middleware' => 'auth'], function (){
    Route::get('/dash', [
        'uses'=> 'HomeController@index',
        'as'=> 'dash.index'
    ]);

    Route::post('/dash/{inicio}/{fin}/fechas',[
        'uses'=>'HomeController@postPedidosGroupFecha',
        'as'=>'dash.fecha'
    ]);

    //******************************************************PEDIDOS
    Route::resource('/pedidos', 'PedidosController');

    Route::post('post.pedidos',[
        'uses'=>'PedidosController@postPedidos',
        'as'=>'pedidos.estados'
    ]);

    Route::post('post.pedidos.cantidad',[
        'uses'=>'PedidosController@postCantidad',
        'as'=>'pedidos.cantidad'
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
    //******************************************************

    //******************************************************ASIGNADOR
    Route::resource('/asignaciones','AsignacionesController');

    //******************************************************VERIFICACION
    Route::resource('/verificacion','VerificacionController');

    //******************************************************AUTORIZADOR
    Route::resource('/autorizador','AutorizadorController');

    Route::get('/get.cambiarUsu/{usu}/{opcion}',[
        'uses'=>'AutorizadorController@getCambiarRango',
        'as'=>'autorizador.cambiar'
    ]);
    //******************************************************

    //******************************************************DEVOLUCION
    Route::resource('/devolucion','DevolucionesController');


    //******************************************************RESPONSABLE
    Route::resource('/responsable','ResponsableController');

    Route::post('/post.responsableProceso',[
        'uses'=>'ResponsableController@postProceso',
        'as'=>'pedidos.proceso'
    ]);

    Route::get('/responsable/{id}/completar',[
        'uses'=>'ResponsableController@getCompletarPedido',
        'as'=>'responsable.completar'
    ]);
    //******************************************************

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

    //******************************************************CAMBIO DE CONTRASEÑA
    Route::resource('/cambiar-pass','UpdatePasswordController');
    //******************************************************

    //******************************************************CAMBIO DE CONTRASEÑA
    Route::resource('/responsable-entrega','ResponsableEntregaController');
    //******************************************************

});
//Route::get('/home', 'HomeController@index');
/*Route::get('/batch',function (){
    system("cmd /c C:\Users\djauregui\Desktop\pr.bat");
    system("./bin/winexe -U Administrador%Password //172.20.1.163 'D:\CuboBatchs\CI_batch.bat'");
});
