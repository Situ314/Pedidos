<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Documentos extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documentos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'ubicacion', 'salida_id'
    ];

    public function salida(){
        return $this->belongsTo('App\SalidaAlmacen','salida_id','id');
    }

    public function setUbicacionAttribute($archivo){
        $nombreArchivo = Carbon::now()->year . Carbon::now()->month . Carbon::now()->day
            . "-" .
            Carbon::now()->hour . Carbon::now()->minute . Carbon::now()->second
            . "-" .
            $archivo->getClientOriginalName();

        $this->attributes['ubicacion'] = $nombreArchivo;

        Storage::disk('public')->put($nombreArchivo, \File::get($archivo));
    }
}
