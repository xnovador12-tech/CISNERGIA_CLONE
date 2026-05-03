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
        Schema::create('libro_reclamaciones', function (Blueprint $table) {
            $table->id();

            $table->string('numero_registro')->unique();
            $table->date('fecha_reclamo')->unique();
            // Datos del consumidor
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->enum('tipo_documento', ['DNI', 'CE', 'Pasaporte'])->nullable();
            $table->string('numero_documento')->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();

            // Datos del consumidor
            $table->string('producto_id')->nullable();
            $table->string('nro_pedido')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->decimal('monto_pagado', 10, 2)->nullable();

            $table->string('tipo_reclamo')->nullable();
            $table->text('descripcion_reclamo')->nullable();
            $table->text('solucion_esperada')->nullable();

            $table->enum('estado', ['Pendiente', 'En Proceso', 'Resuelto', 'Rechazado'])->default('Pendiente');

            $table->text('respuesta_empresa')->nullable();
            $table->date('fecha_respuesta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_reclamaciones');
    }
};
