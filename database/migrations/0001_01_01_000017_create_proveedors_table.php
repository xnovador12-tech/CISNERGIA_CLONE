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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('giro')->nullable();
            $table->string('tipo_cuenta_detraccion')->nullable();
            $table->string('entidad_bancaria_detraccion')->nullable();
            $table->string('nro_cuenta_detraccion')->nullable();
            $table->string('direccion_fiscal')->nullable();
            $table->string('name_contacto')->nullable();
            $table->string('email_contacto')->nullable();
            $table->string('nro_celular_contacto')->nullable();
            $table->string('estado')->nullable();
            $table->string('registrado_por')->nullable();
            $table->foreignId('persona_id')->constrained('personas')->onDelete('cascade');
            $table->foreignId('departamento_id')->constrained('departamentos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
