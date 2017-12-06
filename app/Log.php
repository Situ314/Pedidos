<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tabla', 'tipo', 'tabla_id','tabla_campo', 'valor_anterior', 'valor_nuevo', 'ip', 'user_id'
    ];
}
