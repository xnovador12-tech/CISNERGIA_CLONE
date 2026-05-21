<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campanias', function (Blueprint $table) {
            $table->dropColumn('condicion_minimo');
        });

        DB::table('campanias')->where('tipo', 'combo')->update(['tipo' => 'descuento']);

        DB::statement("ALTER TABLE campanias MODIFY COLUMN tipo ENUM('descuento', 'envio_gratis', 'temporada', 'flash_sale') NOT NULL DEFAULT 'descuento'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE campanias MODIFY COLUMN tipo ENUM('descuento', 'envio_gratis', 'combo', 'temporada', 'flash_sale') NOT NULL DEFAULT 'descuento'");

        Schema::table('campanias', function (Blueprint $table) {
            $table->decimal('condicion_minimo', 10, 2)->nullable()->after('descuento_monto');
        });
    }
};
