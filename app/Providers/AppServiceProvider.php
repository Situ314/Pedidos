<?php

namespace App\Providers;

use App\Asignacion;
use App\Documentos;
use App\Empleado;
use App\Empresa;
use App\EstadoPedido;
use App\Item;
use App\ItemPedido;
use App\ItemPedidoEntregado;
use App\ItemTemporal;
use App\ItemTemporalPedido;
use App\Log;
use App\Pedido;
use App\Proyecto;
use App\Responsable;
use App\SalidaAlmacen;
use App\SalidaItem;
use App\User;
use Carbon\Carbon;
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

        //**************************************PEDIDO
        Pedido::created(function ($pedido){
            $this->CreateLog($pedido, "pedido");
        });
        Pedido::updated(function ($pedido){
           $this->UpdateLog($pedido,"pedidos");
        });
        //**************************************

        //**************************************ITEM TEMPORAL
        ItemTemporal::created(function ($item){
            $this->CreateLog($item,"items_temporales");
        });
        ItemTemporal::updated(function ($item){
            $this->UpdateLog($item, "items_temporales");
        });
        //**************************************

        //**************************************ITEM TEMPORAL PEDIDO
        ItemTemporalPedido::created(function ($item_pedido){
           $this->CreateLog($item_pedido,"items_temporales_pedidos");
        });
        ItemTemporalPedido::updated(function ($item_pedido){
            $this->UpdateLog($item_pedido,"items_temporales_pedidos");
        });
        /*ItemTemporalPedido::deleted(function ($item_pedido){
            $this->DeleteLog($item_pedido,"items_temporales_pedidos");
        });*/
        //**************************************

        //**************************************ITEM PEDIDO
        ItemPedido::created(function ($item_pedido){
           $this->CreateLog($item_pedido,"items_pedidos");
        });
        ItemPedido::updated(function ($item_pedido){
            $this->UpdateLog($item_pedido,"items_pedidos");
        });
        //**************************************

        //**************************************ITEM PEDIDO-ENTREGADO
        ItemPedidoEntregado::created(function ($item_pedido_entre){
           $this->CreateLog($item_pedido_entre, "items_pedido_entregado");
        });
        ItemPedidoEntregado::updated(function ($item_pedido_entre){
           $this->UpdateLog($item_pedido_entre,"items_pedido_entregado");
        });
        //**************************************

        EstadoPedido::created(function ($estado_pedido){
           $this->CreateLog($estado_pedido,"estados_pedidos");
        });
        Empleado::created(function ($emp){
            $this->CreateLog($emp,"empleados");
        });

        //**************************************ASIGNACION
        Asignacion::created(function ($asig){
            $this->CreateLog($asig, "asignaciones");
        });
        //**************************************

        //**************************************ITEM
        Item::created(function ($item){
           $this->CreateLog($item,"items");
        });
        Item::updated(function ($item){
            $this->UpdateLog($item,"items");
        });
        //**************************************

        //**************************************RESPONSABLE
        Responsable::created(function ($resp){
           $this->CreateLog($resp,"responsables");
        });
        Responsable::updated(function ($res){
            $this->UpdateLog($res,"responsables");
        });
        //**************************************

        //**************************************SALIDA DE ALMACEN
        SalidaAlmacen::created(function ($sal){
            $this->CreateLog($sal,"salida_almacen");
        });
        SalidaAlmacen::updated(function ($sal){
            $this->UpdateLog($sal,"salida_almacen");
        });
        //**************************************

        //**************************************SALIDA DE ITEMS
        SalidaItem::created(function ($sal_item){
            $this->CreateLog($sal_item,"salida_items");
        });
        SalidaItem::updated(function ($sal_item){
            $this->UpdateLog($sal_item,"salida_items");
        });
        //**************************************

        //**************************************SALIDA DE ITEMS
        Documentos::created(function ($doc){
            $this->CreateLog($doc,"documentos");
        });
        Documentos::updated(function ($doc){
           $this->UpdateLog($doc,"documentos");
        });
        //**************************************

        //**************************************USER
        User::created(function ($usu){
            $this->CreateLog($usu,"users");
        });
        User::updated(function ($usu){
            $this->UpdateLog($usu,"users");
        });
        //**************************************

        Carbon::setLocale('es');
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
