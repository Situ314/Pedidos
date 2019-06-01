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
        'cantidad', 'precio_unitario', 'observaciones', 'pedido_id', 'item_id'
    ];

    public function item(){
        return $this->belongsTo('App\Item','item_id','id');
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = strtoupper($value);
    }
}
