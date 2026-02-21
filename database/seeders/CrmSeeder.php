<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmSeeder extends Seeder
{
    /**
     * Seeder principal para el módulo CRM.
     * Ejecuta todos los seeders del CRM en el orden correcto respetando dependencias.
     * 
     * Uso: php artisan db:seed --class=CrmSeeder
     */
    public function run(): void
    {
        $this->command->info('🚀 Iniciando seeders del módulo CRM...');
        
        // 1. Datos principales del pipeline de ventas
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
        
        // 2. Módulo de postventa (requiere clientes)
        $this->command->info('🎫 Creando tickets de soporte...');
        $this->call(TicketSeeder::class);
        
        $this->command->info('🔧 Creando mantenimientos...');
        $this->call(MantenimientoSeeder::class);
        
        $this->command->info('');
        $this->command->info('✅ Módulo CRM poblado exitosamente!');
        $this->command->info('');
        $this->command->table(
            ['Módulo', 'Datos creados'],
            [
                ['Prospectos', '13 registros (10 producto, 3 servicio)'],
                ['Wishlists', '3 prospectos con wishlist (~12 productos)'],
                ['Oportunidades', '6 registros (1 por etapa, con productos asociados)'],
                ['Cotizaciones', '~6 registros'],
                ['Actividades', '~50 registros'],
                ['Tickets', '6 registros'],
                ['Mantenimientos', '7 registros'],
            ]
        );
    }
}
