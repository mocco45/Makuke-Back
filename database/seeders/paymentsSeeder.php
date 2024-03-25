<?php

namespace Database\Seeders;

use App\Models\Payment_method;
use App\Models\Payment_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class paymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $income = [
            'Interest',
            'Form',
            'Passport',
            'Supporter',
            'Selling Securities',
            'Investment',
            'Miscellaneous'
        ];

        $expense = [
            'Distribute',
            'Employees',
            'Transportation',
            'CEO Goals',
            'Stationery',
            'Support outside branches',
            'Miscellaneous'
        ];

        $methods = [
            'cash',
            'M-Pesa',
            'Tigo Pesa',
            'Airtel Money',
            'Halopesa',
            'NMB Wakala',
            'CRDB Wakala',
            'Control Number',
            'Online Transfer'
        ];

        foreach($methods as $method){
            Payment_method::create([
                'payment_method' => $method,
            ]);
        }

        foreach($income as $type){
            Payment_type::create([
                'payment_type' => $type,
                'type' => 'income'
            ]);
        }

        foreach($expense as $type){
            Payment_type::create([
                'payment_type' => $type,
                'type' => 'expense'
            ]);
        }
    }
}
