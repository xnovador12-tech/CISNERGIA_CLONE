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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('codigo');
            $table->string('tipo_servicio');
            $table->string('descripcion');
            $table->string('estado')->default('Inactivo');
            $table->string('registrado_por')->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedors')->onDelete('cascade');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
