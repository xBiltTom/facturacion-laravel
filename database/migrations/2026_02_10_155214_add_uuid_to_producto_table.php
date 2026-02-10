<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Agregar columna uuid a la tabla producto, que sea unico y no nulo despues de la columna idProducto
        Schema::table('producto', function (Blueprint $table) {
            $table->uuid('uuid')->unique()->nullable(false)->after('idProducto');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('producto', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
