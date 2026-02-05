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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // TK-2024-001
            $table->string('slug')->unique();
            
            // Relaciones
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('venta_id')->nullable()->constrained('sales')->onDelete('set null');
            
            // Clasificación
            $table->string('asunto');
            $table->text('descripcion');
            $table->enum('tipo', [
                'consulta',
                'reclamo',
                'garantia',
                'soporte_tecnico',
                'mantenimiento',
                'facturacion',
                'otro'
            ]);
            $table->enum('categoria', [
                'paneles',
                'inversor',
                'baterias',
                'estructura',
                'cableado',
                'monitoreo',
                'produccion',
                'instalacion',
                'documentacion',
                'otro'
            ])->nullable();
            
            // Prioridad y SLA
            $table->enum('prioridad', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->integer('sla_horas')->default(48); // Tiempo máximo de resolución
            $table->datetime('sla_vencimiento')->nullable();
            $table->boolean('sla_cumplido')->nullable();
            
            // Estado
            $table->enum('estado', [
                'abierto',
                'asignado',
                'en_progreso',
                'pendiente_cliente',
                'pendiente_proveedor',
                'resuelto',
                'cerrado',
                'reabierto'
            ])->default('abierto');
            
            // Fechas
            $table->datetime('fecha_apertura');
            $table->datetime('fecha_primera_respuesta')->nullable();
            $table->datetime('fecha_resolucion')->nullable();
            $table->datetime('fecha_cierre')->nullable();
            
            // Resolución
            $table->text('solucion')->nullable();
            $table->enum('tipo_solucion', [
                'resuelto_remoto',
                'visita_tecnica',
                'cambio_equipo',
                'ajuste_configuracion',
                'capacitacion',
                'sin_solucion',
                'otro'
            ])->nullable();
            
            // Satisfacción
            $table->integer('calificacion_cliente')->nullable(); // 1-5
            $table->text('comentario_cliente')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Agente asignado
            $table->foreignId('tecnico_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            
            // Canal de entrada
            $table->enum('canal', ['web', 'email', 'telefono', 'whatsapp', 'presencial'])->default('web');
            
            // Notas internas
            $table->text('notas_internas')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['cliente_id', 'estado']);
            $table->index(['estado', 'prioridad']);
            $table->index(['user_id', 'estado']);
            $table->index('sla_vencimiento');
        });
        
        // Tabla para mensajes/respuestas del ticket
        Schema::create('ticket_mensajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('mensaje');
            $table->enum('tipo', ['respuesta', 'nota_interna', 'sistema'])->default('respuesta');
            $table->boolean('es_cliente')->default(false); // Si el mensaje es del cliente
            $table->string('adjunto')->nullable();
            $table->timestamps();
            
            $table->index(['ticket_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_mensajes');
        Schema::dropIfExists('tickets');
    }
};
