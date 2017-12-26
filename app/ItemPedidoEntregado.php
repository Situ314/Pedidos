<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedidoEntregado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items_pedido_entregado';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'precio_unitario', 'pedido_id', 'item_id'
    ];
}
