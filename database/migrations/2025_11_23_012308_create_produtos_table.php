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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_con');
            $table->foreign('id_con')->references('id')->on('confeitarias')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_cat');
            $table->foreign('id_cat')->references('id')->on('categorias')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nome');
            $table->string('imagem');
            $table->string('descricao');
            $table->decimal('valor',10,2);
            $table->float('valor_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
