<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\Timbangan;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimbanganSeeder extends Seeder
{

    protected $count;

    public function __construct()
    {

    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $laporans = Laporan::all();

        foreach($laporans as $laporan) {
            $i = 1;

            while($i <= 3) {
                Timbangan::create([
                    'laporan_id' => $laporan->id,
                    'order' => $i,
                    'timbangan_pabrik' => $faker->numberBetween(3600, 14371),
                    'waktu' => date('H:i:s')
                ]);

                $i++;
            }
        }
    }
}
