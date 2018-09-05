<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactoEmpleado extends Model
{
    // Conexión
    protected $connection = 'rrhh';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contactos_empleado';
}
