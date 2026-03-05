<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración unificada: pedidos + detalle_pedidos
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();

            // Relaciones principales
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('tipo_id')->nullable()->constrained('tipos')->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained('categories')->onDelete('set null');

            // Montos
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->string('condicion_pago')->default('Contado');
            $table->boolean('incluye_igv')->default(false);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);

            // Estado y tipo
            $table->enum('estado', ['pendiente', 'proceso', 'entregado', 'cancelado'])->default('pendiente');
            $table->enum('tipo', ['producto', 'servicio'])->default('producto');

            // Flags de Aprobación del Flujo
            $table->boolean('aprobacion_finanzas')->default(false); // ¿Pagó el anticipo?
            $table->boolean('aprobacion_stock')->default(false);    // ¿Hay stock reservado?

            // Logística
            $table->string('direccion_instalacion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->integer('vigencia_dias')->default(15); // Vigencia del pedido en días (15 o 30)
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('set null');

            // Extras
            $table->text('observaciones')->nullable();
            $table->string('origen')->default('manual'); // manual, ecommerce

            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');

            // Producto o servicio
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('subcategories')->onDelete('set null');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('cascade');
            $table->string('tipo')->default('producto'); // producto, servicio, kit
            $table->string('descripcion');

            // Cantidades y precios
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->string('unidad', 20)->default('und');
            $table->decimal('precio_unitario', 11, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 11, 2)->default(0);
            $table->decimal('subtotal', 11, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('pedido_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
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
        Schema::dropIfExists('pedido_cuotas');
        Schema::dropIfExists('detalle_pedidos');
        Schema::dropIfExists('pedidos');
    }
};
