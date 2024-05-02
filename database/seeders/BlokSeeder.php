<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlokSeeder extends Seeder
{
    protected $count;

    public function __construct($count = 1)
    {
        $this->count = $count;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Blok::factory($this->count)->create();
    }
}
