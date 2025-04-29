<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadimos los campos justo tras 'role'
            $table->string('identificacion')->nullable()->after('role');
            $table->string('establecimiento')->nullable()->after('identificacion');
            $table->string('telefono')->nullable()->after('establecimiento');
            $table->string('direccion')->nullable()->after('telefono');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'identificacion',
                'establecimiento',
                'telefono',
                'direccion',
            ]);
        });
    }
};
