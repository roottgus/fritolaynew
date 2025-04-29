<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // Nombre del producto
            $table->string('code');            // Código del producto
            $table->decimal('price', 8, 2);     // Precio (8 dígitos con 2 decimales)
            $table->string('image')->nullable();// URL o path de la imagen
            $table->string('category');        // Categoría
            $table->boolean('available')->default(true); // Si está disponible
            $table->integer('minQuantity')->default(0);    // Cantidad mínima requerida
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
