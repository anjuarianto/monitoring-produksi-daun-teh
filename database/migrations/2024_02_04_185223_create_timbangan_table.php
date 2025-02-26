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
        Schema::create('timbangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_id');
            $table->integer('order');
            $table->integer('timbangan_pabrik');
            $table->time('waktu');
            $table->timestamps();

            $table->foreign('laporan_id')->references('id')->on('laporan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timbangan');
    }
};
