<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'branch_name' => 'Mbeya Mjini',
            'branch_address' => 'Mbeya',
        ]);
        Branch::create([
            'branch_name' => 'Dodoma',
            'branch_address' => 'Dodoma Mjini',
        
        ]);
        Branch::create([
            'branch_name' => 'Iringa',
            'branch_address' => 'Iringa Mjini',
        
        ]);
        Branch::create([
            'branch_name' => 'Mwanza',
            'branch_address' => 'Mwanza Mjini',
        
        ]);
    }
}
