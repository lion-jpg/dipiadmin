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
        Schema::create('proteccions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_pro');              // Campo para los nombres
            $table->string('descripcion_pro');            // Campo para los apellidos
            $table->string('imagen_pro');
            $table->string('video_pro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proteccions');
    }
};
