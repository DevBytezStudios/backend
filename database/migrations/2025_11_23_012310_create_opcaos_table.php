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
        Schema::create('opcaos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_comp');
            $table->foreign('id_comp')->references('id')->on('complementos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nome');
            $table->decimal('valor',10,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcaos');
    }
};
