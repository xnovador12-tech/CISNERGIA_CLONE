<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * NOTA: NO usar WithoutModelEvents aquí.
     * Los modelos CRM (Prospecto, Oportunidad, Cliente, etc.) dependen
     * de boot() events para auto-generar codigo y slug.
     */
    public function run(): void
    {
        // Ubigeo (Departamentos, Provincias, Distritos) - DEBE IR PRIMERO
        $this->call(UbigeoSeeder::class);

        $this->call(IdentificacionTableSeeder::class);
        $this->call(TipoTableSeeder::class);
        $this->call(SedeTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(BancoTableSeeder::class);
        $this->call(TipocuentaTableSeeder::class);
        $this->call(MediopagoTableSeeder::class);
        $this->call(MedidaTableSeeder::class);
        $this->call(MotivoTableSeeder::class);
        $this->call(ComprobanteTableSeeder::class);
        $this->call(MarcaTableSeeder::class);
        $this->call(AlmacenTableSeeder::class);

        // Productos (necesario antes del CRM para las cotizaciones)
        $this->call(ModeloSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);

        // CRM Module Seeders (incluye ClienteSeeder internamente)
        $this->call(CrmSeeder::class);
    }
}
