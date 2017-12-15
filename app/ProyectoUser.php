<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proyectos_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proyecto_id', 'user_id'
    ];
}
