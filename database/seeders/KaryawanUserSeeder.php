<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use Spatie\Permission\Models\Role;

class KaryawanUserSeeder extends Seeder
{
    protected $jumlah;

    public function __construct($jumlah = 10)
    {
        $this->jumlah = $jumlah;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $role = Role::where('name', 'Karyawan')->first();

        for ($i=0; $i < $this->jumlah; $i++) {
            $jenis_pemanen = User::jenis_pemanen()[rand(0,2)];
            $jenis_karyawan = rand(1,2) % 2 == 0 ? User::KARYAWAN_HARIAN_TETAP : User::KARYAWAN_HARIAN_LEPAS;

            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('password'),
                'golongan_id' => Golongan::all()->random()->id,
                'tempat_lahir' => 'Jakarta',
                'jenis_karyawan' => $jenis_karyawan,
                'jenis_pemanen' => $jenis_pemanen,
                'tanggal_lahir' => '1996-10-12',
                'no_handphone' => '081299126614',
                'alamat' => 'Jakarta'
            ]);

            $user->assignRole([$role->id]);
        }
    }
}
