<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedido_verificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_calidad_id')->constrained('pedido_calidad')->onDelete('cascade');
            $table->foreignId('checklist_item_id')->constrained('checklist_items')->onDelete('cascade');
            $table->boolean('cumple')->default(false);
            $table->text('observacion')->nullable();
            $table->foreignId('verificado_por')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('fecha_verificacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_verificaciones');
    }
};
