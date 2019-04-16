<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pedido;

class NotificacionResponsable extends Mailable
{
    use Queueable, SerializesModels;

    protected $pedido;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notificacion-responsable')
            ->subject('Notificación Pedido sin Finalizar')
            ->with([
                'pedido' => $this->pedido,
            ]);

    }
}
