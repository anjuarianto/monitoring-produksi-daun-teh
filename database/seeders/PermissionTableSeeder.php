<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'permission-list', 'permission-create', 'permission-edit','permission-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'blok-list', 'blok-create', 'blok-edit', 'blok-delete',
            'golongan-list', 'golongan-create', 'golongan-edit', 'golongan-delete',
            'karyawan-list', 'karyawan-create', 'karyawan-edit', 'karyawan-delete',
            'daun-list',
            'opsi-mandor-list', 'opsi-mandor-edit',
            'timbangan-list', 'timbangan-create', 'timbangan-edit', 'timbangan-delete',
            'produksi-list', 'produksi-create', 'produksi-edit', 'produksi-delete',
            'laporan-list',
            'absen-karyawan-list', 'absen-karyawan-create', 'absen-karyawan-edit', 'absen-karyawan-delete',
            'hasil-produksi-list'
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
