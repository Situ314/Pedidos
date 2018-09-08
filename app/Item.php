<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
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
        'nombre', 'descripcion', 'precio_unitario', 'id_producto_cubo', 'confirmado','tipo_categoria_id','unidad_id'
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function unidad(){
        return $this->hasOne('App\Unidad','id','unidad_id');
    }

    public function tipo_categoria(){
        return $this->hasOne('App\TipoCategoria','id','tipo_categoria_id');
    }

    //MUTATOR
    // SET Nombre
    public function setNombreAttribute($value){
        $this->attributes['nombre'] = mb_strtoupper($value, 'UTF-8');
    }

//    public function tipo_categoria(){
//        return $this->hasOne('App\Categoria','id','id','tipo_categoria_id')
//    }
}
