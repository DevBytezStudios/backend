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
        Schema::create('pedido_item_opcaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido_item')->nullable();
            $table->foreign('id_pedido_item')->references('id')->on('pedido_items')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_opcao')->nullable();
            $table->foreign('id_opcao')->references('id')->on('opcaos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_item_opcaos');
    }
};
