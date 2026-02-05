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
        Schema::create('prospectos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('slug')->unique();
            
            // Datos de identificación
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('ruc', 11)->nullable();
            $table->string('dni', 8)->nullable();
            
            // Datos de contacto
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');
            
            // Clasificación
            $table->enum('tipo_persona', ['natural', 'juridica'])->default('natural');
            $table->enum('origen', ['web', 'facebook', 'instagram', 'google_ads', 'referido', 'llamada', 'visita', 'feria', 'otro'])->default('web');
            $table->string('origen_detalle')->nullable(); // Campaña específica, nombre del referido, etc.
            $table->enum('segmento', ['residencial', 'comercial', 'industrial', 'agricola'])->default('residencial');
            
            // Lead Scoring
            $table->enum('scoring', ['A', 'B', 'C'])->default('C');
            $table->integer('scoring_puntos')->default(0); // 0-100
            
            // Estado y seguimiento
            $table->enum('estado', ['nuevo', 'contactado', 'en_seguimiento', 'calificado', 'no_calificado', 'descartado'])->default('nuevo');
            $table->text('motivo_descarte')->nullable();
            $table->date('fecha_primer_contacto')->nullable();
            $table->date('fecha_ultimo_contacto')->nullable();
            $table->date('fecha_proximo_contacto')->nullable();
            
            // Información de interés (específico para energía solar)
            $table->decimal('consumo_mensual_kwh', 12, 2)->nullable();
            $table->decimal('factura_mensual_soles', 12, 2)->nullable();
            $table->string('tipo_inmueble')->nullable(); // casa, departamento, local comercial, nave industrial
            $table->decimal('area_disponible_m2', 10, 2)->nullable();
            $table->boolean('tiene_medidor_bidireccional')->default(false);
            $table->string('empresa_electrica')->nullable(); // Enel, Luz del Sur, etc.
            
            // Presupuesto e interés
            $table->decimal('presupuesto_estimado', 12, 2)->nullable();
            $table->enum('nivel_interes', ['bajo', 'medio', 'alto', 'muy_alto'])->default('medio');
            $table->enum('urgencia', ['inmediata', 'corto_plazo', 'mediano_plazo', 'largo_plazo'])->default('mediano_plazo');
            $table->boolean('requiere_financiamiento')->default(false);
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Vendedor asignado
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            
            // Notas
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['estado', 'scoring']);
            $table->index(['segmento', 'estado']);
            $table->index(['user_id', 'estado']);
            $table->index('fecha_proximo_contacto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospectos');
    }
};
