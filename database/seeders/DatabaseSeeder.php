<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Financials;
use App\Models\Payroll;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  \App\Models\User::factory(4)->create();
        
        $this->call([BranchSeeder::class]);
        $this->call([CategorySeeder::class]);
        $this->call([FinancialSeeder::class]);
        $this->call([PayrollSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([UserSeeder::class]);
    }
}
