<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('golongan');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_handphone');
            $table->text('alamat');
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => password_hash('superadmin', PASSWORD_DEFAULT),
            'golongan' => 00,
            'tempat_lahir' => 'JAKARTA',
            'tanggal_lahir' => date('Y-m-d H:i:s'),
            'no_handphone' => 0000,
            'alamat' => 'Indonesia'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
