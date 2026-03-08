<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campania_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campania_id')->constrained('campanias')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('descuento_especifico', 5, 2)->nullable();
            $table->timestamps();
            $table->unique(['campania_id', 'producto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campania_productos');
    }
};
