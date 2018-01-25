<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    // Conexión
    protected $connection = 'rrhh';

    //public $incrementing = false;
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
        'id','nombres', 'am', 'ap'
    ];

    public function usuario_solicitud(){
        return $this->hasOne('App\UserSolicitud','empleado_id','id');
    }
}
