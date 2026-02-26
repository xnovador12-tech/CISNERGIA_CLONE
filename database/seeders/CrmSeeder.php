<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    /**
     * Seeder principal para el módulo CRM.
     * Ejecuta todos los seeders del CRM en el orden correcto respetando dependencias.
     *
     * Flujo completo de datos:
     *   Prospectos → Oportunidades → Cotizaciones → Actividades
     *                    ↓ (ganadas)
     *               Clientes → Pedidos → Ventas (Sales)
     *                    ↓
     *               Tickets + Mantenimientos
     *
     * Uso: php artisan db:seed --class=CrmSeeder
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando seeders del módulo CRM...');
        $this->command->info('');

        // ── 1. Pipeline de ventas ──
        $this->command->info('═══ PIPELINE DE VENTAS ═══');
        $this->command->info('👥 Creando prospectos...');
        $this->call(ProspectoSeeder::class);

        $this->command->info('❤️ Creando wishlists (ecommerce)...');
        $this->call(WishListSeeder::class);

        $this->command->info('💼 Creando oportunidades...');
        $this->call(OportunidadSeeder::class);

        $this->command->info('📄 Creando cotizaciones...');
        $this->call(CotizacionCrmSeeder::class);

        $this->command->info('📅 Creando actividades...');
        $this->call(ActividadCrmSeeder::class);

        // ── 2. Conversión y ventas ──
        $this->command->info('');
        $this->command->info('═══ CONVERSIÓN Y VENTAS ═══');
        $this->command->info('🔄 Convirtiendo oportunidades ganadas en clientes...');
        $this->call(ClienteSeeder::class);

        $this->command->info('📦 Generando pedidos desde cotizaciones aceptadas...');
        $this->call(PedidoCrmSeeder::class);

        $this->command->info('💰 Generando comprobantes de venta...');
        $this->call(SaleCrmSeeder::class);

        // ── 3. Módulo de postventa ──
        $this->command->info('');
        $this->command->info('═══ POSTVENTA ═══');
        $this->command->info('🎫 Creando tickets de soporte...');
        $this->call(TicketSeeder::class);

        $this->command->info('🔧 Creando mantenimientos...');
        $this->call(MantenimientoSeeder::class);

        // ── Resumen ──
        $this->command->info('');
        $this->command->info('✅ Módulo CRM poblado exitosamente!');
        $this->command->info('');
        $this->command->table(
            ['Módulo', 'Datos creados'],
            [
                ['Prospectos', '13 registros (10 producto, 3 servicio)'],
                ['Wishlists', '3 prospectos con wishlist (~12 productos)'],
                ['Oportunidades', '10 registros (4 pipeline + 5 ganadas + 1 perdida)'],
                ['Cotizaciones', '~9 registros (1 por oportunidad activa/ganada)'],
                ['Actividades', '~50 registros'],
                ['Clientes', '5 registros (desde oportunidades ganadas)'],
                ['Pedidos', '5 registros (desde cotizaciones aceptadas)'],
                ['Ventas', '5 registros (comprobantes desde pedidos)'],
                ['Tickets', '6 registros'],
                ['Mantenimientos', '7 registros'],
            ]
        );
    }
}
