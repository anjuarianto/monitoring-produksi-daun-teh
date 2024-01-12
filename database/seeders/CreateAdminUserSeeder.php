<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
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
            'password' => password_hash('superadmin', PASSWORD_DEFAULT),
            'golongan' => 00,
            'tempat_lahir' => 'JAKARTA',
            'tanggal_lahir' => date('Y-m-d H:i:s'),
            'no_handphone' => 0000,
            'alamat' => 'Indonesia'
        ]);

        $role = Role::create(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
