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
        Schema::create('estilos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_con');
            $table->foreign('id_con')->references('id')->on('confeitarias')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titulo');
            $table->string('descricao');
            $table->string('imagem');
            $table->boolean('active');
            $table->decimal('valor',10,2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estilos');
    }
};
