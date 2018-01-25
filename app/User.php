<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'empleado_id', 'rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function empleado(){
        return $this->belongsTo('App\Empleado','empleado_id','id');
    }

    /*public function proyectos(){
        return $this->belongsToMany('App\Proyecto','proyectos_users','user_id','proyecto_id');
    }*/

    public function rol(){
        return $this->hasOne('App\Rol','id','rol_id');
    }

    public function getEmpleadoUsuarioAttribute()
    {
        return $this->empleado->nombres.' '.$this->empleado->apellido_1.' '.$this->empleado->apellido_2.' ('.$this->username.')';
    }
}
