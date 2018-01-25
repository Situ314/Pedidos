<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSolicitud extends Model
{
    // Conexión
    protected $connection = 'solicitudes';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    public function proyectos(){
        return $this->belongsToMany('App\Proyecto','proyectos_users','user_id','proyecto_id');
    }
}
