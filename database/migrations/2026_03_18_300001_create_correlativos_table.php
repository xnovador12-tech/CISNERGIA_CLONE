<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Quitar correlativo_actual de series_comprobantes
        Schema::table('series_comprobantes', function (Blueprint $table) {
            $table->dropColumn('correlativo_actual');
        });

        // Crear tabla correlativos
        Schema::create('correlativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serie_comprobante_id')->constrained('series_comprobantes')->onDelete('cascade');
            $table->integer('numero')->default(0);
            $table->timestamps();

            $table->unique('serie_comprobante_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correlativos');

        Schema::table('series_comprobantes', function (Blueprint $table) {
            $table->integer('correlativo_actual')->default(0);
        });
    }
};
