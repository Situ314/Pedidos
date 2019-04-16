<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use App\Mail\NotificacionResponsable;

class NotificacionResponsableJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $pedido;
    protected $sendToEmail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pedido,$sendToEmail)
    {
        $this->pedido = $pedido;
        $this->sendToEmail = $sendToEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->sendToEmail)
            ->send(new NotificacionResponsable($this->pedido));
    }
}
