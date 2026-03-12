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
        Schema::create('comprobantes_ventas_detracciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_venta_id');
            $table->foreign('comprobante_venta_id', 'cvd_venta_fk')->references('id')->on('comprobantes_ventas')->onDelete('cascade');

            $table->unsignedBigInteger('tipo_detraccion_id');
            $table->foreign('tipo_detraccion_id', 'cvd_tipo_fk')->references('id')->on('tipo_detraccion')->onDelete('cascade');

            $table->unsignedBigInteger('medio_pago_detraccion_id');
            $table->foreign('medio_pago_detraccion_id', 'cvd_medio_fk')->references('id')->on('medios_pagos_detraccion')->onDelete('cascade');
            
            $table->decimal('porcentaje', 5, 2);
            $table->decimal('monto_detraccion', 15, 2);
            $table->decimal('monto_neto', 15, 2);
            
            $table->string('numero_constancia')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->string('estado')->default('Pendiente');
            $table->string('comprobante_path')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_ventas_detracciones');
    }
};
