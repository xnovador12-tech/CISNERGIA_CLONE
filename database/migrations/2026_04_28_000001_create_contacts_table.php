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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('slug');
            $table->string('email');
            $table->string('telefono');
            $table->string('departamento');
            $table->string('tipo_proyecto');
            $table->text('mensaje');
            $table->string('consumo');
            $table->text('mensaje_respuesta')->nullable();
            $table->string('acepto_terminos');
            $table->string('estado')->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
