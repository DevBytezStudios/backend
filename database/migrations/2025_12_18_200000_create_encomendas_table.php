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
        Schema::create('encomendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_con');
            $table->foreign('id_con')->references('id')->on('confeitarias')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_estilo');
            $table->foreign('id_estilo')->references('id')->on('estilos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
            $table->date('data_entrega');
            $table->string('status');
            $table->string('pagamento');
            $table->string('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomenda__opcaos');
        Schema::dropIfExists('encomendas');
    }
};
