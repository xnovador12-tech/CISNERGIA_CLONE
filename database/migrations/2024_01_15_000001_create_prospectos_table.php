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
            $table->enum('origen', ['sitio_web', 'redes_sociales', 'llamada', 'referido', 'ecommerce', 'otro'])->default('sitio_web');
            $table->enum('segmento', ['residencial', 'comercial', 'industrial', 'agricola'])->default('residencial');
            $table->enum('tipo_interes', ['producto', 'servicio', 'ambos'])->default('producto');
            
            // Estado y seguimiento
            $table->enum('estado', ['nuevo', 'contactado', 'calificado', 'descartado', 'convertido'])->default('nuevo');
            $table->text('motivo_descarte')->nullable();
            $table->date('fecha_primer_contacto')->nullable();
            $table->date('fecha_ultimo_contacto')->nullable();
            $table->date('fecha_proximo_contacto')->nullable();
            
            // Valoración
            $table->enum('nivel_interes', ['bajo', 'medio', 'alto', 'muy_alto'])->nullable();
            $table->enum('urgencia', ['inmediata', 'corto_plazo', 'mediano_plazo', 'largo_plazo'])->nullable();
            
            // Asignación
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Vendedor asignado
            
            // Vínculo con usuario registrado en e-commerce (diferente a user_id que es el vendedor)
            $table->foreignId('registered_user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Notas
            $table->text('observaciones')->nullable();
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['segmento', 'estado']);
            $table->index(['user_id', 'estado']);
            $table->index('fecha_proximo_contacto');
            $table->index('registered_user_id');
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
