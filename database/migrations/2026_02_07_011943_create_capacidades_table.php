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
        Schema::create('capacidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_con');
            $table->foreign('id_con')->references('id')->on('confeitarias')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('limite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacidades');
    }
};
