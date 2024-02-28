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
            $table->float('luas_areal');
            $table->unsignedBigInteger('blok_id');
            $table->unsignedBigInteger('mandor_id');
            $table->timestamps();
            $table->foreign('timbangan_id')->references('id')->on('timbangan');
            $table->foreign('blok_id')->references('id')->on('blok');
            $table->foreign('mandor_id')->references('id')->on('users');
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
