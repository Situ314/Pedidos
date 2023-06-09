<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'empleado_id', 'rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function empleado(){
        return $this->belongsTo('App\Empleado','empleado_id','id');
    }

    public function empleado_nombres(){
        return $this->belongsTo('App\Empleado','empleado_id','id')
            ->select(['id','nombres','apellido_1','apellido_2','apellido_3']);
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

    //UNICAMENTE CUANDO EL USUARIO ES AUTORIZADOR
    public function solicitantes(){
        return $this->belongsToMany('App\User','responsables','autorizador_id','solicitante_id');
    }

    //PARA USUARIOS Y ASI OBTENER A SUSU AUTORIZADORES
    public function autorizadores (){
        return $this->belongsToMany('App\User','responsables','solicitante_id','autorizador_id');
    }
}
