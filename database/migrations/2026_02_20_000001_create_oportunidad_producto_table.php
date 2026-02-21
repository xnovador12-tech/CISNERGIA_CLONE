<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oportunidad_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oportunidad_id')->constrained('oportunidades')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2)->default(1);
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('oportunidad_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oportunidad_producto');
    }
};
