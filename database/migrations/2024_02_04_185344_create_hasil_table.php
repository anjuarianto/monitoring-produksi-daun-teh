<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timbangan_id');
            $table->float('luas_areal_pm');
            $table->float('luas_areal_pg');
            $table->float('luas_areal_os');
            $table->float('pusingan_petikan_ke');
            $table->integer('jumlah_kht_pm');
            $table->integer('jumlah_kht_pg');
            $table->integer('jumlah_kht_os');
            $table->integer('jumlah_khl_pm');
            $table->integer('jumlah_khl_pg');
            $table->integer('jumlah_khl_os');
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
