<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ampliamos el enum para permitir 'proceso' (manteniendo los antiguos temporalmente)
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('pendiente', 'confirmado', 'preparacion', 'despacho', 'entregado', 'cancelado', 'proceso') DEFAULT 'pendiente'");

        // 2. Ahora que 'proceso' es legal, actualizamos los datos
        DB::table('pedidos')
            ->whereIn('estado', ['confirmado', 'preparacion', 'despacho'])
            ->update(['estado' => 'proceso']);

        // 3. Finalmente restringimos el enum a los estados definitivos
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('pendiente', 'proceso', 'entregado', 'cancelado') DEFAULT 'pendiente'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pedidos MODIFY COLUMN estado ENUM('pendiente', 'confirmado', 'preparacion', 'despacho', 'entregado', 'cancelado') DEFAULT 'pendiente'");
    }
};
