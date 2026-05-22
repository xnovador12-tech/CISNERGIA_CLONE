<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantillas_email', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('asunto')->nullable();
            $table->longText('contenido_html');
            $table->string('logo_path')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('es_global')->default(true);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plantillas_email');
    }
};
