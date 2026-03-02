<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    public function run(): void
    {
        // Pipeline de ventas
        $this->call(ProspectoSeeder::class);
        $this->call(WishListSeeder::class);
        $this->call(OportunidadSeeder::class);
        $this->call(CotizacionCrmSeeder::class);
        $this->call(ActividadCrmSeeder::class);

        // Conversión y ventas
        $this->call(ClienteSeeder::class);
        $this->call(PedidoCrmSeeder::class);
        $this->call(SaleCrmSeeder::class);

        // Postventa
        $this->call(TicketSeeder::class);
        $this->call(MantenimientoSeeder::class);
    }
}
