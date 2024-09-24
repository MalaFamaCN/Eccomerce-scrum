<?php

namespace App\Console\Commands;
use App\Models\Pedido;
use App\Http\Controllers\PedidoController;
use Carbon\Carbon;
use Illuminate\Console\Command;

class autoCancelarPedido extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-cancelar-pedidos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pone un tiempo limite para pagar pedidos, si no se pagan en el tiempo indicado, se cancelan automaticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $segundos = 30;
        $pedidoController = app(PedidoController::class); //Uso el controlador de pedidos
        $horaActual = Carbon::now(); //Traigo Hora actual del servidor
        $pedidos = Pedido::where('pagado', false)->where('cancelado', false)->get(); //Consulto por los pedidos que no estan ni pagados, ni cancelados
        foreach ($pedidos as $pedido) { //Recorro todos esos pedidos
            $idPedido = $pedido->id; //Saco ID del pedido
            $fechaPedido = $pedido->created_at; //Veo la fecha de creacion del pedido
            $diferencia = $horaActual->diffInSeconds($fechaPedido); //Calculo la diferencia entre fecha de creacion y fecha actual
            if ($diferencia > $segundos) { //Si la diferencia cumple esto ejecuto la cancelacion del pedido
                $pedidoController->cancelarPedido($idPedido);//Cancelo los pedidos que cumplen la condicion
                $this->info("El id del pedido cancelado es:" . $idPedido);
            } else {
                $this->info("El id del pedido NO cancelado es:" . $idPedido);
            }
            }
        return Command::SUCCESS;
    }
}
