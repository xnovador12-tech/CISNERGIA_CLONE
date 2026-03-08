<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campania_metricas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campania_id')->constrained('campanias')->onDelete('cascade');
            $table->date('fecha');
            $table->integer('visitas')->default(0);
            $table->integer('pedidos_generados')->default(0);
            $table->integer('productos_vendidos')->default(0);
            $table->decimal('monto_total', 12, 2)->default(0);
            $table->decimal('descuento_total_aplicado', 12, 2)->default(0);
            $table->timestamps();
            $table->unique(['campania_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campania_metricas');
    }
};
