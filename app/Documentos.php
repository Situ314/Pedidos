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
        'nombre', 'mime', 'ubicacion', 'salida_id', 'salida_tic_id', 'pedido_id', 'tipo_documento_id'
    ];

    public function salida(){
        return $this->belongsTo('App\SalidaAlmacen','salida_id','id');
    }

    public function salida_tic(){
        return $this->belongsTo('App\SalidaAlmacenTic','salida_tic_id','id');
    }

    public function setUbicacionAttribute($archivo){
        $nombreArchivo = Carbon::now()->year . Carbon::now()->month . Carbon::now()->day
            . "-" .
            Carbon::now()->hour . Carbon::now()->minute . Carbon::now()->second
            . "-" .
            $archivo->getClientOriginalName();

        $this->attributes['ubicacion'] = $nombreArchivo;
        $this->attributes['mime'] = $archivo->getClientMimeType();

        Storage::disk('local')->put($nombreArchivo, \File::get($archivo));
    }
}
