<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CargoRRHH extends Model
{
    // Conexión
    protected $connection = 'rrhh';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cargos';
}
