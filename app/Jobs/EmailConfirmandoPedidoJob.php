<?php

namespace App\Jobs;

use App\Mail\PedidoMailable;
use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailConfirmandoPedidoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $id;
    public function __construct($id) {
        $this->id = $id;
        }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pedido = Pedido::find($this->id);
        $data = [
            'name' => $pedido->nombre . " " . $pedido->apellido,
            'email' => $pedido->correo, // Correo del Destinatario
            'num_pedido' => $pedido->num_pedido,
            'fecha' => $pedido->created_at
            ];
            // Envio de mail
            Mail::to($data['email'])->send(new PedidoMailable($data));
    }
}
