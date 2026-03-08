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

            // Montos
            $table->decimal('subtotal', 11, 2)->default(0);
            $table->boolean('incluye_igv')->default(false);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 11, 2)->default(0);
            $table->decimal('igv', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);

            // Estado y tipo
            $table->enum('estado', ['pendiente', 'proceso', 'entregado', 'cancelado', 'confirmado'])->default('pendiente');
            $table->enum('tipo', ['producto', 'servicio'])->default('producto');
            $table->foreignId('tipo_id')->nullable()->constrained('tipos')->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->string('condicion_pago')->default('Contado'); // Contado, Crédito, etc.

            // Flags de Aprobación del Flujo
            $table->boolean('aprobacion_finanzas')->default(false); // ¿Pagó el anticipo?
            $table->boolean('aprobacion_stock')->default(false);    // ¿Hay stock reservado?

            // Logística
            $table->string('direccion_instalacion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->integer('vigencia_dias')->default(15); // Vigencia del pedido en días (15 o 30)
            $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('set null');

            // Operaciones
            $table->enum('estado_operativo', ['sin_asignar', 'logistica', 'almacen', 'calidad', 'despacho', 'completado'])->default('sin_asignar');
            $table->string('area_actual')->nullable();
            $table->foreignId('tecnico_asignado_id')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('fecha_asignacion')->nullable();
            $table->enum('prioridad', ['alta', 'media', 'baja'])->default('media');
            $table->text('observaciones_operativas')->nullable();
            $table->unsignedBigInteger('campania_id')->nullable();
            $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones_crm')->onDelete('set null');

            // Extras
            $table->text('observaciones')->nullable();
            $table->enum('origen', ['directo', 'ecommerce', 'cotizacion'])->default('directo'); // SOLO 3 formas permitidas

            // Detalles de Pago (Voucher)
            $table->string('pago_banco')->nullable();
            $table->string('pago_operacion')->nullable();
            $table->decimal('pago_monto', 11, 2)->nullable();
            $table->date('pago_fecha')->nullable();
            $table->string('pago_comprobante')->nullable(); // Path del voucher

            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
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

        // detalle_pedidos se crea en migración 000046
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
