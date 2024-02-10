<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('password'),
            'golongan_id' => 1,
            'jenis_karyawan' => NULL,
            'tempat_lahir' => 'JAKARTA',
            'tanggal_lahir' => date('Y-m-d H:i:s'),
            'no_handphone' => 0000,
            'alamat' => 'Indonesia'
        ]);

        $role = Role::where(['name' => 'Admin'])->first();
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
