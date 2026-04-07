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
        Schema::create('complementos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prod');
            $table->foreign('id_prod')->references('id')->on('produtos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titulo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementos');
    }
};
