<?php

namespace Database\Seeders;

use App\Models\Golongan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MandorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Mandor',
            'email' => 'mandor@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('password'),
            'golongan_id' => Golongan::all()->random()->id,
            'tempat_lahir' => 'Jakarta',
            'jenis_karyawan' => NULL,
            'tanggal_lahir' => '1996-10-12',
            'no_handphone' => '081299126614',
            'alamat' => 'Jakarta'
        ]);

        $role = Role::where('name', 'Mandor')->first();
        
        $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Krani Timbang Lapangan',
            'email' => 'krani@mail.com',
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
