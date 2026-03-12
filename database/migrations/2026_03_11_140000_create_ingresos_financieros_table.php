<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingresos_financieros', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $blueprint->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $blueprint->date('fecha_movimiento');
            $blueprint->time('hora_movimiento');
            $blueprint->foreignId('cuenta_bancaria_id')->constrained('cuentas_bancarias')->onDelete('cascade');
            $blueprint->string('origen_tipo');
            $blueprint->foreignId('apertura_caja_id')->constrained('apertura_cierres_caja')->onDelete('cascade');
            $blueprint->foreignId('venta_id')->nullable()->constrained('sales')->onDelete('set null');
            $blueprint->decimal('monto', 15, 2);
            $blueprint->foreignId('moneda_id')->constrained('monedas')->onDelete('cascade');
            $blueprint->string('nombre')->nullable();
            $blueprint->string('numero_operacion')->nullable();
            $blueprint->foreignId('tipo_ingreso_id')->constrained('tipo_ingreso')->onDelete('cascade');
            $blueprint->foreignId('tipo_comprobante_id')->nullable()->constrained('tipos_comprobantes')->onDelete('set null');
            $blueprint->string('comprobante')->nullable();
            $blueprint->text('descripcion')->nullable();
            $blueprint->foreignId('metodo_pago_id')->nullable()->constrained('mediopagos')->onDelete('set null');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos_financieros');
    }
};
