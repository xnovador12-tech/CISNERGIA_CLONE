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
        Schema::create('garantias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // GAR-2024-001
            $table->string('slug')->unique();
            
            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('venta_id')->nullable()->constrained('sales')->onDelete('set null');
            $table->foreignId('producto_id')->nullable()->constrained('productos')->onDelete('set null');
            
            // Tipo de garantía
            $table->enum('tipo', [
                'paneles',
                'inversor',
                'baterias',
                'estructura',
                'instalacion',
                'sistema_completo'
            ]);
            
            // Datos del producto/equipo
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->integer('cantidad')->default(1);
            
            // Vigencia
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('anos_garantia');
            $table->enum('estado', ['vigente', 'vencida', 'anulada', 'aplicada'])->default('vigente');
            
            // Condiciones
            $table->text('condiciones')->nullable();
            $table->text('exclusiones')->nullable();
            
            // Cobertura
            $table->boolean('cubre_mano_obra')->default(true);
            $table->boolean('cubre_repuestos')->default(true);
            $table->boolean('cubre_transporte')->default(false);
            
            // Historial de uso (JSON)
            $table->integer('veces_utilizada')->default(0);
            
            // Documentos
            $table->string('certificado_garantia')->nullable(); // Path al PDF
            
            // Notas
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['cliente_id', 'estado']);
            $table->index(['fecha_fin', 'estado']);
            $table->index('numero_serie');
        });
        
        // Historial de uso de garantías
        Schema::create('garantia_usos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garantia_id')->constrained('garantias')->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->constrained('tickets')->onDelete('set null');
            $table->date('fecha_uso');
            $table->string('motivo');
            $table->text('descripcion_problema');
            $table->text('solucion_aplicada')->nullable();
            $table->decimal('costo_cubierto', 10, 2)->default(0);
            $table->string('tecnico_responsable')->nullable();
            $table->text('observaciones')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['garantia_id', 'fecha_uso']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garantia_usos');
        Schema::dropIfExists('garantias');
    }
};
