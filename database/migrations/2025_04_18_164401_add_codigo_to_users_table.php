<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Solo añadimos la columna si aún no existe
            if (! Schema::hasColumn('users', 'codigo')) {
                $table->string('codigo', 6)
                      ->nullable()
                      ->unique()
                      ->after('id');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'codigo')) {
                // Eliminamos primero la restricción única
                $table->dropUnique('users_codigo_unique');
                // Luego la columna
                $table->dropColumn('codigo');
            }
        });
    }
};
