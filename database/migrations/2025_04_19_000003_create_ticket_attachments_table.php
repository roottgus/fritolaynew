<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')
                  ->constrained('ticket_messages')
                  ->cascadeOnDelete();
            $table->string('path')->comment('Ruta al fichero subido en storage/app');
            $table->string('filename')->nullable()->comment('Nombre original del archivo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ticket_attachments');
    }
};
