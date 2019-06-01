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
        'cantidad', 'observaciones', 'pedido_id', 'item_temp_id', 'tipo_compra_id'
    ];

    public function item(){
        return $this->belongsTo('App\ItemTemporal','item_temp_id','id');
    }

    public function tipo_compra(){
        return $this->belongsTo('App\TipoCompra','tipo_compra_id','id');
    }

    public function control_stock(){
        return $this->hasMany('App\ControlStock','items_temporales_pedidos_id','id');
    }

    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = strtoupper($value);
    }
}
