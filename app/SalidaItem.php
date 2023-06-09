<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salida_items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantidad', 'observacion', 'item_pedido_entregado_id', 'salida_id'
    ];

    public function item_pedido_entregado(){
        return $this->hasOne('App\ItemPedidoEntregado','id','item_pedido_entregado_id');
    }

    public function salida_almacen(){
        return $this->belongsTo('App\SalidaAlmacen','id','salida_id');
    }
}
