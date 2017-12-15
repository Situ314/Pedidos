<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
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
        'codigo', 'proyecto_id', 'tipo_categoria_id', 'solicitante_id'
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

    public function estados_pedido(){
        return $this->hasMany('App\EstadoPedido','pedido_id','id');
    }

    public function proyecto(){
        return $this->hasOne('App\Proyecto','id','proyecto_id');
    }
}
