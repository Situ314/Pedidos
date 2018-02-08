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

    public function getNombreCompletoAttribute(){
        return $this->nombres.' '.$this->apellido_1.' '.$this->apellido_2;
    }

    public function laboral_empleado(){
        return $this->hasOne('App\LaboralEmpleadoRRHH','empleado_id','id');
    }

    public function proyecto(){
        return $this->belongsTo('App\Proyecto','sol_proyecto_id','id');
    }
}
