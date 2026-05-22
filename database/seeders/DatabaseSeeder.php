<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * ORDEN CRÍTICO:
     *   1. RoleTableSeeder        → crea los 8 roles
     *   2. PermissionSeeder       → crea los ~70 permisos
     *   3. RolePermissionSeeder   → asigna permisos a Gerencia y Administrador
     *   4. UserTableSeeder        → crea usuarios y les asigna roles
     *
     * Los seeders "pesados" (catálogos, ubigeo, productos) corren UNA SOLA VEZ
     * cuando la BD está vacía. Los seeders idempotentes (plantillas marketing)
     * siempre corren.
     */
    public function run(): void
    {
        $primerArranque = $this->esPrimerArranque();

        if ($primerArranque) {
            $this->seedersPesados();
        } else {
            $this->command->info('BD ya inicializada. Saltando seeders pesados de catálogos.');
        }

        $this->seedersIdempotentes();
    }

    private function esPrimerArranque(): bool
    {
        if (!Schema::hasTable('departamentos')) {
            return true;
        }
        return DB::table('departamentos')->count() === 0;
    }

    private function seedersPesados(): void
    {
        $this->call(UbigeoSeeder::class);
        $this->call(IdentificacionTableSeeder::class);
        $this->call(TipoTableSeeder::class);
        $this->call(SedeTableSeeder::class);

        $this->call(RoleTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(UserTableSeeder::class);

        $this->call(CategoryTableSeeder::class);
        $this->call(MonedaSeeder::class);
        $this->call(BancoTableSeeder::class);
        $this->call(TipocuentaTableSeeder::class);
        $this->call(MediopagoTableSeeder::class);
        $this->call(MedidaTableSeeder::class);
        $this->call(MotivoTableSeeder::class);
        $this->call(ComprobanteTableSeeder::class);
        $this->call(SunatMotivoNotaSeeder::class);
        $this->call(MarcaTableSeeder::class);
        $this->call(AlmacenTableSeeder::class);
        $this->call(TipoOperacionSeeder::class);
        $this->call(CuentabancoSeeder::class);
        $this->call(AperturaCierreCajaSeeder::class);
        $this->call(TipoDetraccionSeeder::class);
        $this->call(SerieComprobanteSeeder::class);
        $this->call(CuentaBancariaTestSeeder::class);

        $this->call(ModeloSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);

        $this->call(ServicioSeeder::class);

        $this->call(ChecklistItemTableSeeder::class);
        $this->call(KanbanTestDataSeeder::class);
        $this->call(OrdenCompraTestSeeder::class);
        $this->call(OrdenCompraCuotasTestSeeder::class);
    }

    private function seedersIdempotentes(): void
    {
        $this->call(PlantillasEmailSeeder::class);
    }
}
