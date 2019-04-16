<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pedido;

class InformePedidos extends Mailable
{
    use Queueable, SerializesModels;

    protected $pedido;
    protected $responsable;
    protected $tipo;
    protected $attachFile;
    protected $mensaje;
    protected $receptor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $pedido, $responsable, $tipo, $attachFile, $mensaje, $receptor)
    {
        $this->pedido = $pedido;
        $this->responsable = $responsable;
        $this->tipo = $tipo;
        $this->attachFile = $attachFile;
        $this->mensaje = $mensaje;
        $this->receptor = $receptor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

//        return $this->view('view.name');
        return $this->view('mail.informe-pedido')
            ->subject('Informe Pedidos sin Finalizar (Estado: "'.$this->tipo.'"")')
            ->attachData($this->attachFile->output(), 'Informe.pdf', ['mime' => 'application/pdf'])
            ->with([
                'pedidos' => $this->pedido,
                'responsable' => $this->responsable,
                'tipo' => $this->tipo,
                'mensaje' => $this->mensaje,
                'receptor' => $this->receptor,
            ]);
    }
}
