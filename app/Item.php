<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'precio_unitario', 'id_producto_cubo','tipo_categoria_id','unidad_id'
    ];

    public function unidad(){
        return $this->hasOne('App\Unidad','id','unidad_id');
    }

    public function tipo_categoria(){
        return $this->hasOne('App\Categoria','id','tipo_categoria_id');
    }
}
