<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones_crm', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            $table->integer('version')->default(1);
            
            // Relaciones
            $table->foreignId('oportunidad_id')->constrained('oportunidades')->onDelete('cascade');
            $table->foreignId('prospecto_id')->nullable()->constrained('prospectos')->onDelete('set null');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            
            // Datos del proyecto
            $table->string('nombre_proyecto');
            
            // Totales (calculados desde los ítems del detalle)
            // Precisión 14,6: permite montos hasta S/ 99,999,999.99 con 6 decimales
            // para cálculos intermedios de IGV sin perder ningún céntimo.
            // SUNAT exige presentar con 2 decimales, pero internamente operamos a 6.
            $table->decimal('subtotal',            14, 6)->default(0);
            $table->decimal('descuento_porcentaje', 7, 4)->default(0); // Ej: 12.5000%
            $table->decimal('descuento_monto',     14, 6)->default(0);
            $table->boolean('incluye_igv')->default(true);
            $table->decimal('igv',                 14, 6)->default(0);
            $table->decimal('total',               14, 6)->default(0);
            
            // Plazos
            $table->integer('tiempo_ejecucion_dias')->default(0);
            $table->string('garantia_servicio')->nullable();
            $table->date('fecha_emision');
            $table->date('fecha_vigencia');
            
            // Estado
            $table->enum('estado', [
                'borrador',
                'enviada',
                'aceptada',
                'rechazada'
            ])->default('borrador');
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_respuesta')->nullable();
            $table->text('motivo_rechazo')->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Notas
            $table->text('condiciones_comerciales')->nullable();
            $table->text('notas_internas')->nullable();
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['oportunidad_id', 'version']);
            $table->index(['estado', 'fecha_vigencia']);
            $table->index('fecha_emision');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones_crm');
    }
};
