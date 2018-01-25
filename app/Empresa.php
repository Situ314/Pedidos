<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    // Conexión
    protected $connection = 'solicitudes';
//    public $incrementing = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empresas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'descripcion'
    ];
}
