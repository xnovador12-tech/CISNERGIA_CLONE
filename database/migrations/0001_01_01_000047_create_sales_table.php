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
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            $table->enum('tipo_venta', ['pos', 'pedido', 'ecommerce'])->default('pos');
            
            // Campos específicos para proyectos energéticos
            $table->string('tipo_proyecto')->nullable(); // residencial, comercial, industrial, agricola
            $table->decimal('potencia_kw', 11, 2)->nullable(); // Potencia total del sistema instalado
            $table->date('fecha_instalacion')->nullable(); // Fecha programada de instalación
            $table->integer('garantia_sistema_años')->default(10); // Garantía del sistema completo
            $table->boolean('requiere_financiamiento')->default(false);
            $table->decimal('monto_financiado', 11, 2)->nullable();
            $table->string('entidad_financiera')->nullable();
            $table->decimal('consumo_mensual_kwh', 11, 2)->nullable(); // Consumo actual del cliente
            $table->string('numero_proyecto')->nullable(); // Código interno del proyecto
            
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
