<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendSalesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:send-pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía las ventas pendientes a OSE/SUNAT de forma correlativa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
