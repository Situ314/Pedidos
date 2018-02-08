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
        'codigo', 'num_solicitud', 'proyecto_id', 'tipo_categoria_id', 'solicitante_id', 'solicitud_id'
    ];

    public function solicitante(){
        return $this->hasOne('App\User','id','solicitante_id');
    }

    public function items(){
        return $this->belongsToMany('App\Item','items_pedidos','pedido_id','item_id');
    }

    public function items_pedido(){
        return $this->hasMany('App\ItemPedido','pedido_id','id');
    }

    public function items_temp_pedido(){
        return $this->hasMany('App\ItemTemporalPedido','pedido_id','id');
    }

    public function items_entrega(){
        return $this->hasMany('App\ItemPedidoEntregado','pedido_id','id');
    }

    public function estados_pedido(){
        return $this->hasMany('App\EstadoPedido','pedido_id','id');
    }

    public function proyecto(){
        return $this->hasOne('App\Proyecto','id','proyecto_id');
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
}
