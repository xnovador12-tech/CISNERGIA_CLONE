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
        Schema::create('detalle_cotizaciones_crm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizaciones_crm')->onDelete('cascade');
            
            // Categoría del ítem
            $table->enum('categoria', [
                'equipo',
                'mano_obra', 
                'servicio',
                'material',
                'tramite',
                'otro'
            ])->default('equipo');
            
            // Descripción del ítem
            $table->string('codigo_item')->nullable();
            $table->string('descripcion');
            $table->text('especificaciones')->nullable();
            
            // Cantidades
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->string('unidad', 20)->default('und');
            
            // Precios
            $table->decimal('precio_unitario', 12, 2)->default(0);
            $table->decimal('descuento_porcentaje', 5, 2)->default(0);
            $table->decimal('descuento_monto', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            
            // Orden de visualización
            $table->integer('orden')->default(0);
            
            // Opcional: vincular a un producto del inventario
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('set null');
            
            $table->timestamps();
            
            // Índices
            $table->index(['cotizacion_id', 'categoria']);
            $table->index('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cotizaciones_crm');
    }
};
