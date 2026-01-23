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
        Schema::create('confeitarias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug');
            $table->string('telefone')->default('');
            $table->string('cor_princ')->default('black');
            $table->string('cor_sec')->default('black');
            $table->string('logo')->default('semImagem.jpg');
            $table->string('email');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confeitarias');
    }
};
