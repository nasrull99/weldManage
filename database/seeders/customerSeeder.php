<?php

namespace Database\Seeders;

use App\Models\customer;
use Illuminate\Database\Seeder;

class customerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        customer::factory()
            ->count(5)
            ->create();
    }
}
