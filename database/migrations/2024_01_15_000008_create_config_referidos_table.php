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
        Schema::create('config_referidos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('activo')->default(false);
            $table->string('tipo_recompensa_referente')->default('monto'); // monto, porcentaje
            $table->decimal('valor_recompensa_referente', 12, 2)->default(0);
            $table->string('tipo_recompensa_referido')->default('monto'); // monto, porcentaje
            $table->decimal('valor_recompensa_referido', 12, 2)->default(0);
            $table->decimal('monto_minimo_venta', 12, 2)->default(0);
            $table->text('terminos_condiciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_referidos');
    }
};
