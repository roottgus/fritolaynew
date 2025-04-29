<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Nombre de la categoría, p.ej. Soporte Técnico');
            $table->timestamps();
        });

        // Añadimos la columna category_id a tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('priority')
                  ->constrained('ticket_categories')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        // Primero quitamos la FK
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
        Schema::dropIfExists('ticket_categories');
    }
};
