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
        Schema::create('encomenda_opcaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_encomenda');
            $table->foreign('id_encomenda')->references('id')->on('encomendas')->onDelete('cascade')->onUpdate('cascade');
            $table->string("etapa");
            $table->string('nome');
            $table->decimal('valor', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomenda_opcaos');
    }
};
