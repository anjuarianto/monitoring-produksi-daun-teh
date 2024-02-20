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
            new BlokSeeder(10),
            new CreateAdminUserSeeder(),
            new KraniUserSeeder(4),
            new MandorUserSeeder(12),
            new KaryawanUserSeeder(100),
            new LaporanSeeder(),
            new TimbanganSeeder()
        ];

        foreach ($seeders as $key => $seeder) {
            $seeder->run();
        }

    }
}
