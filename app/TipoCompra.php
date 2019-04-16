<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCompra extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_compras';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion'
    ];
}
