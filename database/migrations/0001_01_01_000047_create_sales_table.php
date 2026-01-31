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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('tiposcomprobante_id')->nullable()->constrained('tiposcomprobantes')->onDelete('set null');
            $table->string('numero_comprobante')->nullable();
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->decimal('descuento', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->foreignId('mediopago_id')->nullable()->constrained('mediopagos')->onDelete('set null');
            $table->enum('estado', ['completada', 'parcial', 'anulada'])->default('completada');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
