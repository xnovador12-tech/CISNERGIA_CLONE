<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
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

        // Marcas y Productos (necesario antes del CRM para las cotizaciones)
        $this->call(MarcaTableSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);
        $this->call(ClienteSeeder::class);

        // CRM Module Seeders
        $this->call(CrmSeeder::class);
    }
}
