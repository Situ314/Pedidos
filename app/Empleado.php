<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empleados';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombres'
    ];
}
