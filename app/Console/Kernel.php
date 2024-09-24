<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
    Frecuencias de actualizacion
    https://laravel.com/docs/10.x/scheduling#schedule-frequency-options
     */
    

    protected function schedule(Schedule $schedule): void
    {
        $idPedido = 2;
        $schedule->command('auto-cancelar-pedidos')->everyFifteenSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
