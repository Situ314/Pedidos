<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaboralEmpleadoRRHH extends Model
{
    // Conexión
    protected $connection = 'rrhh';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laborales_empleado';

    public function cargo(){
        return $this->hasOne('App\CargoRRHH','id','cargo_id');
    }
}
