<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'ALPHA',
            'start_range' => 50000,
            'final_range' => 150000,
            'duration' => 1,
            'interest' => 20,
        ]);

        Category::create([
            'name' => 'BETA',
            'start_range' => 200000,
            'final_range' => 350000,
            'duration' => 1,
            'interest' => 20,
        ]);

        Category::create([
            'name' => 'GAMMA',
            'start_range' => 400000,
            'final_range' => 550000,
            'duration' => 1,
            'interest' => 20,
        ]);

        Category::create([
            'name' => 'MEGA',
            'start_range' => 600000,
            'final_range' => 750000,
            'duration' => 1,
            'interest' => 20,
        ]);

        Category::create([
            'name' => 'SUPER_1',
            'start_range' => 800000,
            'final_range' => 900000,
            'duration' => 2,
            'interest' => 30,
        ]);

        Category::create([
            'name' => 'SUPER_2',
            'start_range' => 950000,
            'final_range' => 1000000,
            'duration' => 3,
            'interest' => 30,
        ]);
      
    }
}
