<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marketing_leads_sociales', function (Blueprint $table) {
            $table->id();
            $table->enum('plataforma', ['facebook', 'instagram']);
            $table->string('social_id');
            $table->string('nombre_social')->nullable();
            $table->foreignId('prospecto_id')->nullable()->constrained('prospectos')->nullOnDelete();
            $table->unsignedInteger('puntaje_interes')->default(0);
            $table->text('comentario_origen')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['plataforma', 'social_id']);
            $table->index('prospecto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketing_leads_sociales');
    }
};
