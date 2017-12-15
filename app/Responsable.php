<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'responsables';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'autorizador_id', 'solicitante_id'
    ];

    public function autorizador(){
        return $this->belongsTo('App\User','autorizador_id','id');
    }

    public function solicitante(){
        return $this->belongsTo('App\User','solicitante_id','id');
    }
}
