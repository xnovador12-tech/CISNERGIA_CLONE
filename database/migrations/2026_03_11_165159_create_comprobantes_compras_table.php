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
        Schema::create('comprobantes_compras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->nullable();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('sede_id');
            $table->unsignedBigInteger('ordencompra_id')->nullable();
            $table->unsignedBigInteger('tiposcomprobante_id');
            $table->string('numero_comprobante'); // El número de la factura del proveedor
            $table->decimal('subtotal', 12, 2);
            $table->decimal('igv', 12, 2);
            $table->decimal('total', 12, 2);
            $table->unsignedBigInteger('moneda_id')->nullable();
            $table->unsignedBigInteger('mediopago_id')->nullable();
            $table->string('condicion_pago')->nullable(); // Contado / Credito
            $table->enum('estado', ['borrador', 'completada', 'anulada'])->default('completada');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->foreign('ordencompra_id')->references('id')->on('ordenescompras');
            $table->foreign('tiposcomprobante_id')->references('id')->on('tiposcomprobantes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantes_compras');
    }
};
