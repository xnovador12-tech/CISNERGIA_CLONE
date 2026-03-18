<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            $table->foreignId('sale_id')->constrained('sales')->cascadeOnDelete();
            $table->foreignId('tiposcomprobante_id')->constrained('tiposcomprobantes');
            $table->string('numero_comprobante');
            $table->string('motivo_codigo', 2);
            $table->string('motivo_descripcion');
            $table->decimal('subtotal', 11, 2);
            $table->decimal('igv', 11, 2);
            $table->decimal('total', 11, 2);
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['emitida', 'anulada'])->default('emitida');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('sede_id')->nullable()->constrained('sedes');
            $table->date('fecha_emision');
            $table->timestamps();
        });

        Schema::create('nota_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_id')->constrained('notas')->cascadeOnDelete();
            $table->foreignId('producto_id')->nullable()->constrained('productos');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios');
            $table->string('descripcion');
            $table->decimal('cantidad', 11, 2);
            $table->decimal('precio_unitario', 11, 2);
            $table->decimal('subtotal', 11, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_detalles');
        Schema::dropIfExists('notas');
    }
};
