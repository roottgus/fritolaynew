<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('minQuantity')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('minQuantity')->nullable(false)->change();
        });
    }
};
