<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items_pedidos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'precio_unitario', 'pedido_id', 'item_id'
    ];

    public function item(){
        return $this->belongsTo('App\Item','item_id','id');
    }
}
