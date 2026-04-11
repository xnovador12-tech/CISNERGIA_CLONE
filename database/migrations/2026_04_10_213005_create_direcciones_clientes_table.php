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
        Schema::create('direcciones_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable();
            $table->string('departamento_id')->nullable();
            $table->string('provincia_id')->nullable();
            $table->string('distrito_id')->nullable();
            $table->string('cliente_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones_clientes');
    }
};
