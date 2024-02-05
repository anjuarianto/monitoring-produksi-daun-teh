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
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timbangan_id');
            $table->integer('jumlah');
            $table->integer('luas_areal');
            $table->unsignedBigInteger('blok_id');
            $table->timestamps();
            $table->foreign('timbangan_id')->references('id')->on('timbangan');
            $table->foreign('blok_id')->references('id')->on('blok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil');
    }
};
