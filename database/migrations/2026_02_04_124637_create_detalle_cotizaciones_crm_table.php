<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_cotizaciones_crm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones_crm')->onDelete('cascade');
            
            // Categoría del ítem
            $table->enum('categoria', [
                'producto',  // Productos del catálogo (paneles, inversores, etc.)
                'servicio',  // Instalación, mantenimiento, trámites, mano de obra, etc.
                'otro'       // Ítem libre: garantías extendidas, seguros, otros conceptos
            ])->default('producto');
            
            // Descripción del ítem
            $table->string('codigo_item')->nullable();
            $table->string('descripcion');
            $table->text('especificaciones')->nullable();
            
            // Cantidades — 4 decimales: permite fracciones como 0.0025 m² de cable
            $table->decimal('cantidad', 10, 4)->default(1);
            $table->string('unidad', 20)->default('und');
            
            // Precios — 6 decimales para no perder céntimos en operaciones encadenadas
            $table->decimal('precio_unitario',      14, 6)->default(0);
            $table->decimal('descuento_porcentaje',  7, 4)->default(0);
            $table->decimal('descuento_monto',      14, 6)->default(0);
            $table->decimal('subtotal',             14, 6)->default(0);
            
            // Orden de visualización
            $table->integer('orden')->default(0);
            
            // Vínculos al catálogo
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('set null');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios')->onDelete('set null');

            // Solo para ítems de tipo servicio
            $table->integer('tiempo_ejecucion_dias')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['cotizacion_id', 'categoria']);
            $table->index('orden');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_cotizaciones_crm');
    }
};
