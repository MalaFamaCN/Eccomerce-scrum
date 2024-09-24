<?php

namespace App\Jobs;

use App\Mail\EnviarFacturaMailable;
use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarFacturaJob implements ShouldQueue
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
        //
        $pedido = Pedido::find($this->id);
        $data = [
            'name' => $pedido->nombre . " " . $pedido->apellido,
            'email' => $pedido->correo, // Correo del Destinatario
            'num_pedido' => $pedido->num_pedido,
            'fecha' => $pedido->created_at,
            'fecha_pago' => $pedido->updated_at,
            'urlFactura' => public_path('storage/pdfs/facturas/factura_' . $pedido->num_pedido . '.pdf')
            ];

            /* Mail::to($data['email'])->send(new EnviarFacturaMailable($data)); */
            if (!$pedido->factura_enviada) { // Envio de mail si no existe 
                Mail::to($data['email'])->send(new EnviarFacturaMailable($data)); 
                $pedido->factura_enviada = true;
                $pedido->save();
            } 
           
            
    }
}
