<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración unificada: sales + detail_sales
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();

            // Relaciones principales
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('tiposcomprobante_id')->nullable()->constrained('tiposcomprobantes')->onDelete('set null');
            $table->foreignId('tipo_operacion_id')->nullable()->constrained('tipos_operaciones')->nullOnDelete();
            $table->foreignId('tipo_detraccion_id')->nullable()->constrained('tipo_detraccion')->nullOnDelete();
            $table->string('numero_comprobante')->nullable();
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->time('hora')->nullable();

            // Serie y correlativo (FK se agrega en migración de series_comprobantes)
            $table->unsignedBigInteger('serie_id')->nullable();
            $table->string('serie', 10)->nullable();
            $table->integer('correlativo')->nullable();

            // Montos
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->decimal('descuento', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->decimal('monto_detraccion', 15, 2)->default(0);
            $table->decimal('monto_neto', 15, 2)->default(0);

            // Pago y estado
            $table->foreignId('mediopago_id')->nullable()->constrained('mediopagos')->onDelete('set null');
            $table->string('billetera')->nullable();
            $table->unsignedBigInteger('cuenta_bancaria_id')->nullable();
            $table->string('condicion_pago')->default('Contado');
            $table->enum('estado', ['completada', 'parcial', 'anulada'])->default('completada');
            $table->string('estado_msalida')->default('0'); // 0: no generado, 1: generado
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDeleteñ('set null');
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
            $table->boolean('anulado')->default(false);
            $table->boolean('estado_sunat')->default(false);
            $table->string('mensaje_sunat')->nullable();
            $table->string('nombre_xml_sunat')->nullable();
            

            $table->timestamps();
        });

        Schema::create('detail_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');

            // Producto o servicio
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('set null');
            $table->string('tipo')->default('producto'); // producto, servicio, kit
            $table->string('descripcion');

            // Cantidades y precios
            $table->decimal('cantidad', 11, 2)->default(1);
            $table->decimal('precio_unitario', 11, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 11, 2)->default(0);
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->integer('garantia_años')->nullable(); // Garantía específica del item

            $table->timestamps();
        });

        Schema::create('sale_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->integer('numero_cuota');
            $table->decimal('importe', 11, 2);
            $table->date('fecha_vencimiento')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_cuotas');
        Schema::dropIfExists('detail_sales');
        Schema::dropIfExists('sales');
    }
};
