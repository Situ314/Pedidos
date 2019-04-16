<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

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
        'id', 'nombre', 'descripcion', 'empresa_id', 'padre_id'
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

    public function padre(){
        return $this->hasOne('App\Proyecto','id','padre_id');
    }

    public function get_hijos(){
//        $var = $this->hasMany('App\Proyecto','padre_id','id')->nivel;
        $nivel = $this->nivel;
        $nombre_completo = $this->nombre;
        $proyecto_actual = Proyecto::find($this->id);
        for($i=0;$i<$nivel-1;$i++){
            $nombre_completo = $proyecto_actual->padre->nombre.' &#10148 '.$nombre_completo;
            $proyecto_actual = Proyecto::find($proyecto_actual->padre->id);
        }
        return $nombre_completo;
    }

}
