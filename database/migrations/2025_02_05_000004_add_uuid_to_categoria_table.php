<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar columna uuid a la tabla categoria
        Schema::table('categoria', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('idCategoria');
        });

        // Generar UUIDs para registros existentes
        DB::table('categoria')->whereNull('uuid')->get()->each(function ($categoria) {
            DB::table('categoria')
                ->where('idCategoria', $categoria->idCategoria)
                ->update(['uuid' => (string) Str::uuid()]);
        });

        // Hacer el campo único y no nullable
        Schema::table('categoria', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categoria', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
