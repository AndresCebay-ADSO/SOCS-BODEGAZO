<?php

namespace App\Jobs;

use App\Models\Usuario;
use App\Notifications\BulkMessageNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendBulkNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Creamos la notificación que se va a enviar
        $notificationToSend = new BulkMessageNotification($this->message);

        // Obtenemos los usuarios activos en lotes de 100 para no agotar la memoria
        Usuario::where('estadoUsu', 'Activo')->chunkById(100, function ($usuarios) use ($notificationToSend) {
            // Enviamos la notificación al lote actual de usuarios
            Notification::send($usuarios, $notificationToSend);
        });
    }
}