<?php

namespace Database\Seeders;

use App\Models\Promocion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class promocionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Promocion::factory()->count(50)->create();
    }
}
