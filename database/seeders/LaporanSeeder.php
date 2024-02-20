<?php

namespace Database\Seeders;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    protected $count;

    public function __construct($count = 10)
    {
        $this->count = $count;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < $this->count ; $i++) {
            Laporan::create([
                'tanggal' => date('Y-m-d', strtotime('-'.$i.' days')),
                'petugas_id' => User::role('Krani Timbang Lapangan')->pluck('id')->random()
            ]);
        }
    }
}
