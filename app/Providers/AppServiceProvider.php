<?php

namespace App\Providers;

use App\Asignacion;
use App\Empleado;
use App\Empresa;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemTemporal;
use App\ItemTemporalPedido;
use App\Log;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use function foo\func;
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
            $this->CreateLog($empresa, "empresas");
        });

        Proyecto::created(function ($proyecto){
            $this->CreateLog($proyecto, "proyectos");
        });

        Pedido::created(function ($pedido){
            $this->CreateLog($pedido, "pedido");
        });

        ItemTemporal::created(function ($item){
            $this->CreateLog($item,"items_temporales");
        });

        ItemTemporalPedido::created(function ($item_pedido){
           $this->CreateLog($item_pedido,"items_temporales_pedidos");
        });

        ItemPedido::created(function ($item_pedido){
           $this->CreateLog($item_pedido,"items_pedidos");
        });

        EstadoPedido::created(function ($estado_pedido){
           $this->CreateLog($estado_pedido,"estados_pedidos");
        });

        Empleado::created(function ($emp){
            $this->CreateLog($emp,"empleados");
        });

        Asignacion::created(function ($asig){
            $this->CreateLog($asig, "asignaciones");
        });

        Item::created(function ($item){
           $this->CreateLog($item,"items");
        });

        Responsable::created(function ($resp){
           $this->CreateLog($resp,"responsables");
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

    public function CreateLog($obj, $tabla){
        Log::create([
            'tabla'=>$tabla,
            'tipo'=>'C',
            'tabla_id'=>$obj->id,
            'ip'=>\Request::ip(),
            'user_id'=>Auth::id()
        ]);
    }

    public function UpdateLog($obj, $tabla){
        $diff = array_diff_assoc($obj['attributes'], $obj['original']);
        foreach ($diff as $key => $value){
            if($key != 'id' && $key != 'created_at' && $key != 'updated_at') {
                Log::create([
                    'tabla'=>$tabla,
                    'tipo'=>'U',
                    'tabla_id'=>$obj->id,
                    'tabla_campo'=>$key,
                    'valor_anterior'=>($obj['original'][$key]!='')?$obj['original'][$key]:null,
                    'valor_nuevo'=>($value != '')?$value:null,
                    'ip'=>\Request::ip(),
                    'user_id'=>Auth::id()
                ]);
            }
        }
    }
}
