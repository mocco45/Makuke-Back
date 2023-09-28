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
            'branch_name' => 'MBEYA MJINI',
            'branch_address' => 'MBEYA',
        ]);
        Branch::create([
            'branch_name' => 'DODOMA',
            'branch_address' => 'DODOMA MJINI',
        
        ]);
        Branch::create([
            'branch_name' => 'IRINGA',
            'branch_address' => 'IRINGA MJINI',
        
        ]);
        Branch::create([
            'branch_name' => 'MWANZA',
            'branch_address' => 'MWANZA MJINI',
        
        ]);
    }
}
