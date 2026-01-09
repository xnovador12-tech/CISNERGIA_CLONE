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
        Schema::create('detail_discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('porcentaje');
            $table->decimal('precio', 11,2)->default(0);
            $table->decimal('precio_descuento', 11,2)->default(0);
            $table->string('codigo_curso');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->unsignedBigInteger('discount_id');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_discounts');
    }
};
