<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'CEO']);
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Loan Officer']);
        Role::create(['name' => 'Cashier']);
        Role::create(['name' => 'Director']);
    }
}
