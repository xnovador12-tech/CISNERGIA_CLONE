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
        Schema::create('items_venta', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 15, 2)->default(0);
            $table->string('estado')->default('Activo');
            
            $table->foreignId('categoria_id')->constrained('items_venta_categorias')->onDelete('cascade');
            $table->foreignId('unidad_medida_id')->constrained('unidad_medida')->onDelete('cascade');
            $table->foreignId('tipo_afectacion_id')->constrained('tipo_afectaciones')->onDelete('cascade');
            $table->foreignId('sede_id')->constrained('sedes')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_venta');
    }
};
