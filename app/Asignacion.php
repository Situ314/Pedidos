<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asignaciones';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asignado_id', 'pedido_id'
    ];
}
