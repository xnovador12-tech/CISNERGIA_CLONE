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
        Schema::create('detalle_comprobantes_ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_venta_id');
            $table->foreign('comprobante_venta_id', 'dcv_venta_fk')->references('id')->on('comprobantes_ventas')->onDelete('cascade');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id', 'dcv_item_fk')->references('id')->on('items_venta')->onDelete('cascade');
            
            $table->unsignedBigInteger('tipo_afectacion_id');
            $table->foreign('tipo_afectacion_id', 'dcv_afect_fk')->references('id')->on('tipo_afectaciones')->onDelete('cascade');

            $table->unsignedBigInteger('unidad_medida_id');
            $table->foreign('unidad_medida_id', 'dcv_unidad_fk')->references('id')->on('unidad_medida')->onDelete('cascade');
            
            $table->string('descripcion');
            $table->decimal('cantidad', 15, 2);
            $table->decimal('precio_unitario', 15, 2);
            $table->decimal('descuento', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('igv', 15, 2);
            $table->decimal('total', 15, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_comprobantes_ventas');
    }
};
