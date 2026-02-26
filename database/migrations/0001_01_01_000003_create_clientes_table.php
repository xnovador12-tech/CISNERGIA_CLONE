<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración unificada de clientes (E-commerce + CRM)
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Identificación del sistema (nullable para que boot() los genere)
            $table->string('codigo')->nullable()->unique();
            $table->string('slug')->nullable()->unique();

            // Datos personales
            $table->string('nombre');
            $table->string('apellidos')->nullable();
            $table->string('razon_social')->nullable();
            $table->enum('tipo_persona', ['natural', 'juridica'])->default('natural');
            $table->string('ruc', 11)->nullable();
            $table->string('dni', 8)->nullable();

            // Contacto
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();

            // Ubicación
            $table->string('direccion')->nullable();
            $table->foreignId('distrito_id')->nullable()->constrained('distritos')->onDelete('set null');

            // Clasificación
            $table->enum('origen', ['ecommerce', 'directo'])->default('directo');
            $table->enum('segmento', ['residencial', 'comercial', 'industrial', 'agricola'])->default('residencial');
            $table->enum('estado', ['activo', 'inactivo', 'suspendido'])->default('activo');

            // Trazabilidad CRM
            $table->unsignedBigInteger('prospecto_id')->nullable();
            $table->foreignId('vendedor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Fechas
            $table->date('fecha_primera_compra')->nullable();

            // Adicional
            $table->foreignId('sede_id')->nullable()->constrained('sedes')->onDelete('set null');
            $table->text('observaciones')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index(['segmento', 'estado']);
            $table->index(['vendedor_id', 'estado']);
            $table->index('origen');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
