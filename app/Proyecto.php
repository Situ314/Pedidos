<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // Conexión
    protected $connection = 'solicitudes';
//    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proyectos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion', 'empresa_id'
    ];

    public function empresa(){
        return $this->hasOne('App\Empresa','id','empresa_id');
    }

    public function users(){
        return $this->belongsToMany('App\User','proyectos_users','proyecto_id','user_id');
    }

    public function getProyectoEmpresaAttribute()
    {
        return $this->nombre.' ('.$this->empresa->nombre.')';
    }
}
