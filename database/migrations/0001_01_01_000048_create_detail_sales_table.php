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
        Schema::create('detail_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
            $table->string('tipo')->default('producto'); // producto, servicio, kit
            $table->string('descripcion');
            $table->decimal('cantidad', 11, 2)->default(1); // Decimal para fracciones (ej: 2.5 kW)
            $table->decimal('precio_unitario', 11, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0); // % descuento
            $table->decimal('descuento_monto', 11, 2)->default(0); // Monto descuento
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->integer('garantia_años')->nullable(); // Garantía específica del item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_sales');
    }
};
