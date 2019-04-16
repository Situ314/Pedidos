<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encargados';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exclusivo','tipo_categoria_id', 'user_id'
    ];
}
