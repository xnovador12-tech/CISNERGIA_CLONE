<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('name');       // Nombre del servicio: Instalación, Mantenimiento, etc.
            $table->string('slug');
            $table->string('codigo');
            // Tipo: si es contratado con una empresa pública (distribuidora, OSINERGMIN)
            // o privada (cliente directo de Cisnergia)
            $table->enum('tipo_servicio', ['publico', 'privado'])->default('privado');
            $table->string('descripcion');
            $table->string('estado')->default('Inactivo');
            $table->string('registrado_por')->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedors')->onDelete('cascade');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
