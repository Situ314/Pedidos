<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parametros';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'horas'
    ];
}
