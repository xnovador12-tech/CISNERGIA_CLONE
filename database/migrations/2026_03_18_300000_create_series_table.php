<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tiposcomprobante_id')->constrained('tiposcomprobantes')->onDelete('cascade');
            $table->string('serie', 10); // F001, B001, FC01, etc.
            $table->integer('correlativo')->default(0);
            $table->timestamps();

            $table->unique(['tiposcomprobante_id', 'serie']);
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('serie_id')->references('id')->on('series')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['serie_id']);
        });
        Schema::dropIfExists('series');
    }
};
