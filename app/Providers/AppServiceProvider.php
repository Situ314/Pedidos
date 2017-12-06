<?php

namespace App\Providers;

use App\Empresa;
use App\Log;
use App\Pedido;
use App\Proyecto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Empresa::created(function ($empresa){
            Log::create([
                'tabla'=>'empresas',
                'tipo'=>'C',
                'tabla_id'=>$empresa->id,
                'ip'=>\Request::ip(),
                'user_id'=>Auth::id()
            ]);
        });

        Proyecto::created(function ($proyecto){
           Log::create([
               'tabla'=>'proyectos',
               'tipo'=>'C',
               'tabla_id'=>$proyecto->id,
               'ip'=>\Request::ip(),
               'user_id'=>Auth::id()
           ]);
        });

        Pedido::created(function ($pedido){
            Log::create([
                'tabla'=>'pedido',
                'tipo'=>'C',
                'tabla_id'=>$pedido->id,
                'ip'=>\Request::ip(),
                'user_id'=>Auth::id()
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
