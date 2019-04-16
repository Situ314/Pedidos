<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlStock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'control_stock';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock', 'revisor_id', 'items_pedidos_id', 'items_temporales_pedidos_id'
    ];

    public function items_pedidos(){
        return $this->belongsTo('App\ItemPedido','items_pedidos_id','id');
    }

    public function items_temporales_pedidos(){
        return $this->belongsTo('App\ItemTemporalPedido','items_temporales_pedidos_id','id');
    }
}
