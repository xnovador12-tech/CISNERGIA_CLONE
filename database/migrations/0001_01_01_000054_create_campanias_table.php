<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('slug', 150)->unique();
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['descuento', 'envio_gratis', 'combo', 'temporada', 'flash_sale'])->default('descuento');
            $table->decimal('descuento_porcentaje', 5, 2)->nullable();
            $table->decimal('descuento_monto', 10, 2)->nullable();
            $table->decimal('condicion_minimo', 10, 2)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['borrador', 'activa', 'pausada', 'finalizada'])->default('borrador');
            $table->string('imagen_banner', 255)->nullable();
            $table->boolean('aplica_todos_productos')->default(false);
            $table->foreignId('creado_por')->constrained('users')->onDelete('cascade');
            $table->foreignId('activado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('activado_at')->nullable();
            $table->foreignId('pausado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('pausado_at')->nullable();
            $table->string('motivo_pausa', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campanias');
    }
};
