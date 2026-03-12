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
        Schema::create('detalle_comprobantes_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_compra_id');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->string('descripcion');
            $table->decimal('cantidad', 15, 2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('igv', 15, 2);
            $table->decimal('total', 15, 2);
            $table->unsignedBigInteger('unidad_medida_id')->nullable();
            $table->timestamps();

            $table->foreign('comprobante_compra_id', 'fk_det_comp_comp_id')->references('id')->on('comprobantes_compras')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_comprobantes_compras');
    }
};
