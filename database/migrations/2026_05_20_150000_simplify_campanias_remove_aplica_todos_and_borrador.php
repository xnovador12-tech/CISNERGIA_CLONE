<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('campanias')->where('estado', 'borrador')->update(['estado' => 'activa']);

        DB::statement("ALTER TABLE campanias MODIFY COLUMN estado ENUM('activa', 'pausada', 'finalizada') NOT NULL DEFAULT 'activa'");

        Schema::table('campanias', function (Blueprint $table) {
            $table->dropColumn('aplica_todos_productos');
        });
    }

    public function down(): void
    {
        Schema::table('campanias', function (Blueprint $table) {
            $table->boolean('aplica_todos_productos')->default(false);
        });

        DB::statement("ALTER TABLE campanias MODIFY COLUMN estado ENUM('borrador', 'activa', 'pausada', 'finalizada') NOT NULL DEFAULT 'borrador'");
    }
};
