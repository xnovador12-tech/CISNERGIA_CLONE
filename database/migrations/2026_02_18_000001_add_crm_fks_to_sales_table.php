<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar campos CRM a la tabla sales para vincular
     * venta con oportunidad y cotización de origen.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('oportunidad_id')
                  ->nullable()
                  ->after('pedido_id')
                  ->constrained('oportunidades')
                  ->onDelete('set null');

            $table->foreignId('cotizacion_crm_id')
                  ->nullable()
                  ->after('oportunidad_id')
                  ->constrained('cotizaciones_crm')
                  ->onDelete('set null');

            // Índice para consultar ventas pendientes de registro
            $table->index(['oportunidad_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['oportunidad_id']);
            $table->dropForeign(['cotizacion_crm_id']);
            $table->dropIndex(['oportunidad_id', 'estado']);
            $table->dropColumn(['oportunidad_id', 'cotizacion_crm_id']);
        });
    }
};
