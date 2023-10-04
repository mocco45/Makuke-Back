<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::create(['name' => 'Borrower Report']);
        Report::create(['name' => 'Loan Report']);
        Report::create(['name' => 'Monthly Report']);
        Report::create(['name' => 'Loan Product Report']);
        Report::create(['name' => 'Financial Statement Report']);
        
    }
}
