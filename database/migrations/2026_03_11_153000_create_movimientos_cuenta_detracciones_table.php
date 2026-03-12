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
        Schema::create('movimientos_cuenta_detracciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_movimiento'); // Ejemplo: Ingreso, Egreso, Detracción
            $table->decimal('monto', 15, 2);
            $table->unsignedBigInteger('comprobante_venta_detraccion_id');
            $table->foreign('comprobante_venta_detraccion_id', 'mcd_cvd_fk')->references('id')->on('comprobantes_ventas_detracciones')->onDelete('cascade');

            $table->unsignedBigInteger('ingreso_financiero_id');
            $table->foreign('ingreso_financiero_id', 'mcd_ingreso_fk')->references('id')->on('ingresos_financieros')->onDelete('cascade');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_cuenta_detracciones');
    }
};
