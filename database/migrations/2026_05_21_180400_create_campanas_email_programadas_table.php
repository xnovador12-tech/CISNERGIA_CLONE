<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campanas_email_programadas', function (Blueprint $table) {
            $table->id();
            $table->string('asunto');
            $table->json('destinatarios');
            $table->longText('contenido_html');
            $table->string('logo_path')->nullable();
            $table->json('adjuntos')->nullable();
            $table->dateTime('enviar_el');
            $table->enum('estado', ['pendiente', 'procesando', 'enviado', 'fallido', 'parcial'])->default('pendiente');
            $table->unsignedInteger('enviados_count')->default(0);
            $table->unsignedInteger('fallidos_count')->default(0);
            $table->text('detalle_error')->nullable();
            $table->dateTime('procesado_en')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['estado', 'enviar_el']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campanas_email_programadas');
    }
};
