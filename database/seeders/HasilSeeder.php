<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Hasil;
use App\Models\HasilHasKaryawan;
use App\Models\Mandor;
use App\Models\Timbangan;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HasilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $timbangans = Timbangan::get();

        foreach($timbangans as $timbangan) {

            $counterHasil = 0;
            while($counterHasil < 2) {
                $hasil = Hasil::create([
                    'timbangan_id' => $timbangan->id,
                    'jumlah' => $faker->numberBetween(593, 3000),
                    'luas_areal' => $faker->randomFloat(4, 1, 10),
                    'blok_id' => Blok::all()->random()->id,
                    'mandor_id' => User::role('Mandor')->get()->random()->id
                ]);

                $counterKaryawan = 0;
                while($counterKaryawan <= rand(5, 8)) {
                    HasilHasKaryawan::create([
                        'user_id' => User::role('Karyawan')->get()->random()->id,
                        'hasil_id' => $hasil->id
                    ]);
                    $counterKaryawan++;
                }


                $counterHasil++;
            }
        }

    }
}
