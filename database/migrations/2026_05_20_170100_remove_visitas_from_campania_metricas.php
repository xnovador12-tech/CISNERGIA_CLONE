<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('campania_metricas', function (Blueprint $table) {
            if (Schema::hasColumn('campania_metricas', 'visitas')) {
                $table->dropColumn('visitas');
            }
        });
    }

    public function down(): void
    {
        Schema::table('campania_metricas', function (Blueprint $table) {
            $table->integer('visitas')->default(0);
        });
    }
};
