<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_calidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');
            $table->enum('estado_calidad', ['pendiente', 'en_revision', 'aprobado', 'rechazado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->string('area_destino')->nullable(); // área a la que se devuelve al rechazar
            $table->foreignId('verificado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('fecha_verificacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_calidad');
    }
};
