<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTemporalPedido extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items_temporales_pedidos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'pedido_id', 'item_temp_id'
    ];

    public function item(){
        return $this->belongsTo('App\ItemTemporal','item_temp_id','id');
    }
}
