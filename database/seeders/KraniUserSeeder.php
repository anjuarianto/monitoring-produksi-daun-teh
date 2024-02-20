<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class KraniUserSeeder extends Seeder
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
        
        for ($i = 0; $i < $this->count; $i++) {
            $user = User::create([
                'name' => 'Krani Timbang Lapangan ' . $i,
                'email' => 'krani' . $i . '@mail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make('password'),
                'golongan_id' => Golongan::all()->random()->id,
                'tempat_lahir' => 'Jakarta',
                'jenis_karyawan' => NULL,
                'tanggal_lahir' => '1996-10-12',
                'no_handphone' => '081299126614',
                'alamat' => 'Jakarta'
            ]);

            $role = Role::where('name', 'Krani Timbang Lapangan')->first();
         
            $user->assignRole([$role->id]);
        }
    }
}
