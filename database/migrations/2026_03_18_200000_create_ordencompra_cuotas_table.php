<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordencompra_cuotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordencompra_id');
            $table->foreign('ordencompra_id')->references('id')->on('ordenescompras')->onDelete('cascade');
            $table->integer('numero_cuota');
            $table->decimal('importe', 15, 2);
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordencompra_cuotas');
    }
};
