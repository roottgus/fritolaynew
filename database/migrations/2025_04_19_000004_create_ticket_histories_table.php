<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('field')->comment('Campo modificado, e.g. status');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_histories');
    }
};
