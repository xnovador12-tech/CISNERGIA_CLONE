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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->string('estado')->default('Inactivo');
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
