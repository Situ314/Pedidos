<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo', 'proyecto_id', 'tipo_categoria_id', 'solicitante_id', 'solicitud_id'
    ];

    public function solicitante(){
        return $this->hasOne('App\User','id','solicitante_id');
    }

    public function solicitante_empleado(){
        return $this->hasOne('App\User','id','solicitante_id')
            ->with('empleado');
    }

    public function items(){
        return $this->belongsToMany('App\Item','items_pedidos','pedido_id','item_id')
            ->withPivot('cantidad');
    }

    public function items_pedido(){
        return $this->hasMany('App\ItemPedido','pedido_id','id');
    }

    public function items_temp_pedido(){
        return $this->hasMany('App\ItemTemporalPedido','pedido_id','id');
    }

    public function items_temporales(){
        return $this->belongsToMany('App\ItemTemporal','items_temporales_pedidos','pedido_id','item_temp_id')
            ->withPivot('cantidad');
    }

    public function items_entrega(){
        return $this->hasMany('App\ItemPedidoEntregado','pedido_id','id');
    }

    public function items_entregar(){
        return $this->belongsToMany('App\Item','items_pedido_entregado','pedido_id','item_id')
            ->withPivot('cantidad');
    }

    public function estados_pedido(){
        return $this->hasMany('App\EstadoPedido','pedido_id','id');
    }

    public function proyecto(){
        return $this->hasOne('App\Proyecto','id','proyecto_id');
    }

    public function proyecto_empresa(){
        return $this->hasOne('App\Proyecto','id','proyecto_id')
            ->with('empresa');
    }

    public function estados(){
        return $this->belongsToMany('App\Estado','estados_pedidos','pedido_id','estado_id');
    }

    public function salidas_almacen(){
        return $this->hasMany('App\SalidaAlmacen','pedido_id','id');
    }

    public function documentos(){
        return $this->hasMany('App\Documentos','pedido_id','id');
    }

    public function asignados_nombres(){
        return $this->belongsToMany('App\User','asignaciones','pedido_id','asignado_id')
            ->with('empleado_nombres');
    }
}
