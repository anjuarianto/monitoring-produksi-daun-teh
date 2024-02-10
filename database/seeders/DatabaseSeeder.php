<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            new PermissionTableSeeder(),
            new RoleSeeder(),
            new GolonganSeeder(),
            new CreateAdminUserSeeder(),
            new MandorUserSeeder(),
            new KaryawanUserSeeder(100)
        ];

        foreach ($seeders as $key => $seeder) {
            $seeder->run();
        }

    }
}
