<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');         // Referencia al usuario que realizó el pedido
            $table->decimal('total', 10, 2);                 // Total del pedido
            $table->string('status')->default('Pendiente');  // Estado (Pendiente, Despachado, etc.)
            $table->string('origin')->default('Web');        // Origen del pedido
            $table->json('items')->nullable();              // Almacena los artículos (puedes usar JSON)
            $table->timestamps();

            // Clave foránea (si tu tabla de usuarios se llama "users")
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
