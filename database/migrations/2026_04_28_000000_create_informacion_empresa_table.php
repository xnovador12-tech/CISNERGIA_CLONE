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
        Schema::create('informacion_empresa', function (Blueprint $table) {
            $table->id();

            // Datos generales
            $table->string('razon_social');
            $table->string('ruc', 11);
            $table->string('nombre_comercial')->nullable();
            $table->string('logo')->nullable();

            // Contacto
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->string('horario_atencion')->nullable();

            // Redes sociales
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_empresa');
    }
};
