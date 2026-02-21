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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->decimal('descuento', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->enum('estado', ['pendiente', 'confirmado', 'preparacion', 'despacho', 'entregado', 'cancelado'])->default('pendiente');
            
            // Flags de Aprobación del Flujo
            $table->boolean('aprobacion_finanzas')->default(false); // ¿Pagó el anticipo?
            $table->boolean('aprobacion_stock')->default(false);    // ¿Hay stock reservado?
            
            $table->string('direccion_instalacion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->foreignId('tecnico_asignado_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->string('origen')->default('manual'); // manual, ecommerce
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
