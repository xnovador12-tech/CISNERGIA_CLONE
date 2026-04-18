<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * ORDEN CRÍTICO:
     *   1. RoleTableSeeder        → crea los 8 roles
     *   2. PermissionSeeder       → crea los ~70 permisos
     *   3. RolePermissionSeeder   → asigna permisos a Gerencia y Administrador
     *   4. UserTableSeeder        → crea usuarios y les asigna roles (usa assignRole)
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

        // ─── Auth (Spatie) ────────────────────────────────────────────────
        $this->call(RoleTableSeeder::class);       // 1. Roles
        $this->call(PermissionSeeder::class);      // 2. Permisos
        $this->call(RolePermissionSeeder::class);  // 3. Asignación rol ↔ permiso
        $this->call(UserTableSeeder::class);       // 4. Usuarios con assignRole()

        // ─── Catálogos ────────────────────────────────────────────────────
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

        // Productos (necesario antes del CRM para las cotizaciones)
        $this->call(ModeloSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(InventarioSeeder::class);

        // Servicios del catálogo (antes del CRM para trazabilidad en cotizaciones)
        $this->call(ServicioSeeder::class);

        // CRM Module Seeders (incluye ClienteSeeder internamente)
        $this->call(CrmSeeder::class);

        // Operaciones Module Seeders
        $this->call(ChecklistItemTableSeeder::class);
        $this->call(KanbanTestDataSeeder::class);
        $this->call(CampaniaTableSeeder::class);
        $this->call(OrdenCompraTestSeeder::class);
        $this->call(OrdenCompraCuotasTestSeeder::class);
    }
}
