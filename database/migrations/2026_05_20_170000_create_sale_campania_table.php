<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sale_campania', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('campania_id')->constrained('campanias')->onDelete('cascade');
            $table->decimal('monto_aplicado', 11, 2)->default(0);
            $table->decimal('descuento_aplicado', 11, 2)->default(0);
            $table->integer('productos_count')->default(0);
            $table->timestamps();
            $table->unique(['sale_id', 'campania_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_campania');
    }
};
