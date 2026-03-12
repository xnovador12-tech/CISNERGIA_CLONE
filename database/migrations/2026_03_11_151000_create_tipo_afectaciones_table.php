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
        Schema::create('tipo_afectaciones', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('descripcion');
            $table->string('codigo_tributo')->nullable();
            $table->string('tipo_tributo')->nullable();
            $table->string('name_tributo')->nullable();
            $table->decimal('porcentaje', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_afectaciones');
    }
};
