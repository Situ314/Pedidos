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

    Route::resource('/asignaciones','AsignacionesController');

    Route::resource('/verificacion','VerificacionController');

    Route::resource('/autorizador','AutorizadorController');

    Route::resource('/devolucion','DevolucionesController');

    Route::get('/get.cambiarUsu/{usu}/{opcion}',[
        'uses'=>'AutorizadorController@getCambiarRango',
        'as'=>'autorizador.cambiar'
    ]);

    Route::resource('/responsable','ResponsableController');

    Route::post('/post.responsableProceso',[
        'uses'=>'ResponsableController@postProceso',
        'as'=>'pedidos.proceso'
    ]);

    Route::post('/post.items.buscar',[
        'uses'=>'ItemsController@buscarItem',
        'as'=>'buscar.item',
    ]);
});

//Route::get('/home', 'HomeController@index');
