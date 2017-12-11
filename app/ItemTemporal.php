<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTemporal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items_temporales';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'unidad_id'
    ];

    public function unidad(){
        return $this->hasOne('App\Unidad','id','unidad_id');
    }
}
