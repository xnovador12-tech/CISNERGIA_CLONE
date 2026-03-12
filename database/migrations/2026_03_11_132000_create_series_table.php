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
        Schema::create('series', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->foreignId('tipo_comprobante_id')->constrained('tipos_comprobantes')->onDelete('cascade');
            $blueprint->string('name');
            $blueprint->integer('correlativo')->default(1);
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
