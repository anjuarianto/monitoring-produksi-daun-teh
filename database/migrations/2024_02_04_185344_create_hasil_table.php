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
            $table->unsignedBigInteger('laporan_id');
            $table->unsignedBigInteger('timbangan_id');
            $table->float('luas_areal_pm')->nullable();
            $table->float('luas_areal_pg')->nullable();
            $table->float('luas_areal_os')->nullable();
            $table->float('luas_areal_lt')->nullable();
            $table->float('pusingan_petikan_ke')->nullable();
            $table->integer('jumlah_kht_pm')->nullable();
            $table->integer('jumlah_kht_pg')->nullable();
            $table->integer('jumlah_kht_os')->nullable();
            $table->integer('jumlah_kht_lt')->nullable();
            $table->integer('jumlah_khl_pm')->nullable();
            $table->integer('jumlah_khl_pg')->nullable();
            $table->integer('jumlah_khl_os')->nullable();
            $table->integer('jumlah_khl_lt')->nullable();
            $table->unsignedBigInteger('blok_id');
            $table->unsignedBigInteger('mandor_id');
            $table->timestamps();

            $table->foreign('laporan_id')->references('id')->on('laporan')->cascadeOnDelete();
            $table->foreign('timbangan_id')->references('id')->on('timbangan')->cascadeOnDelete();
            $table->foreign('blok_id')->references('id')->on('blok')->cascadeOnDelete();
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
