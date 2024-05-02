<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeders = [
            new PermissionTableSeeder(),
            new RoleSeeder(),
            new CreateAdminUserSeeder()
        ];

        foreach ($seeders as $key => $seeder) {
            $seeder->run();
        }
    }
}
