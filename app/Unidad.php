<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unidades';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion'
    ];

    public function getFullNameAttribute()
    {
        return $this->nombre.' ('.$this->descripcion.')';
    }
}
