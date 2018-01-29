<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalidaAlmacen extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salida_almacen';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'num_ot', 'area', 'num_salida_almacen', 'pedido_id', 'responsable_entrega_id', 'courrier_id'
    ];

    public function documento(){
        return $this->hasOne('App\Documentos','salida_id','id');
    }

    public function salida_items(){
        return $this->hasMany('App\SalidaItem','salida_id','id');
    }

    public function pedido(){
        return $this->belongsTo('App\Pedido','pedido_id','id');
    }
}
