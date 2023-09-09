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
            'name' => 'alpha',
            'start_range' => 50000,
            'final_range' => 150000,
        ]);

        Category::create([
            'name' => 'beta',
            'start_range' => 200000,
            'final_range' => 350000,
        ]);

        Category::create([
            'name' => 'gamma',
            'start_range' => 400000,
            'final_range' => 550000,
        ]);

        Category::create([
            'name' => 'mega',
            'start_range' => 600000,
            'final_range' => 750000,
        ]);

        Category::create([
            'name' => 'super_1',
            'start_range' => 800000,
            'final_range' => 900000,
        ]);

        Category::create([
            'name' => 'super_2',
            'start_range' => 600000,
            'final_range' => 750000,
        ]);

       
    }
}
