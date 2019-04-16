<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

use Mail;
use App\Mail\InformePedidos;

class InformePedidosJob implements ShouldQueue
{
    use DispatchesJobs,InteractsWithQueue, Queueable, SerializesModels;

    protected $pedido;
    protected $responsable;
    protected $tipo;
    protected $attachFile;
    protected $sendToEmail;
    protected $mensaje;
    protected $receptor;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pedido,$responsable,$tipo,$attachFile,$mensaje,$receptor,$sendToEmail)
    {
        $this->pedido = $pedido;
        $this->responsable = $responsable;
        $this->tipo = $tipo;
        $this->attachFile = $attachFile;
        $this->mensaje = $mensaje;
        $this->receptor = $receptor;
        $this->sendToEmail = $sendToEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        dd($this->sendToEmail);
        Mail::to($this->sendToEmail)
            ->send(new InformePedidos($this->pedido,$this->responsable,$this->tipo,$this->attachFile,$this->mensaje,$this->receptor));
    }
}
