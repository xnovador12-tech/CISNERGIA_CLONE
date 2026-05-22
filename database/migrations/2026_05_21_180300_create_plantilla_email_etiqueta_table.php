<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantilla_email_etiqueta', function (Blueprint $table) {
            $table->foreignId('plantilla_email_id')->constrained('plantillas_email')->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained('etiquetas_plantilla')->cascadeOnDelete();
            $table->primary(['plantilla_email_id', 'etiqueta_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantilla_email_etiqueta');
    }
};
