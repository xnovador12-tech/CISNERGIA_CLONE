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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('surnames')->nullable();
            $table->string('email_pnatural')->nullable();
            $table->string('avatar')->nullable();
            $table->string('celular')->nullable();
            $table->string('pais')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('identificacion')->nullable();
            $table->string('nro_identificacion')->nullable();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('tipo_persona');
            $table->string('registrado_por')->nullable();
            $table->foreignId('sede_id')->constrained('sedes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
