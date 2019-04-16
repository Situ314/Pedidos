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
        'cantidad', 'precio_unitario', 'pedido_id', 'item_id', 'tipo_compra_id'
    ];

    public function item(){
        return $this->belongsTo('App\Item','item_id','id');
     }

    public function tipo_compra(){
        return $this->belongsTo('App\TipoCompra','tipo_compra_id','id');
    }

    public function control_stock(){
        return $this->hasMany('App\ControlStock','items_pedidos_id','id');
    }
}
