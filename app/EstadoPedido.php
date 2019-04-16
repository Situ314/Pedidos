<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estados_pedidos';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'estado_id', 'pedido_id', 'motivo'
    ];

    public function usuario(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function estado(){
        return $this->hasOne('App\Estado','id','estado_id');
    }
}
