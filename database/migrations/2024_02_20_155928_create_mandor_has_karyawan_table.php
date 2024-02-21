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
        Schema::create('mandor_has_karyawan', function (Blueprint $table) {
            $table->unsignedBigInteger('mandor_id');
            $table->unsignedBigInteger('karyawan_id');

            $table->foreign('mandor_id')->references('id')->on('users')->onDelete('cascade');;
            $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandor_has_user');
    }
};
