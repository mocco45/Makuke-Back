<?php

namespace Database\Seeders;

use App\Models\Financials;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Financials::create([
            'basicSalary' => 100000,
            'bankAccount' => 15712212,
            'bankAccountHolderName' => 'Test Name',
            'bankName' => 'crdb',
        ]);
    }
}
