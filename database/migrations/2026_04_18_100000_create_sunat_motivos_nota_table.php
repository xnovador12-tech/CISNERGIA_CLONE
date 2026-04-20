<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunat_motivos_nota', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 2);
            $table->string('descripcion');
            $table->foreignId('tiposcomprobante_id')->constrained('tiposcomprobantes')->cascadeOnDelete();
            $table->boolean('estado')->default(true);
            $table->timestamps();

            $table->unique(['codigo', 'tiposcomprobante_id'], 'unique_codigo_tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunat_motivos_nota');
    }
};
