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
        Schema::create('etapas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_con');
            $table->foreign('id_con')->references('id')->on('confeitarias')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nome');
            $table->integer('ordem');
            $table->boolean('required');
            $table->boolean('multiple');
            $table->string('icone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapas');
    }
};
