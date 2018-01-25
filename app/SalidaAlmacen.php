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
        'num_ot', 'area', 'pedido_id', 'responsable_entrega_id'
    ];

    public function documento(){
        return $this->hasOne('App\Documentos','id');
    }
}
