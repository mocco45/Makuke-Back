<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstName' => 'admin',
            'lastName' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'not married',
            'phone' => 744611319,
            'gender' => 'male',
            'street' => 'sabasaba',
            'district' => 'mbeya jiji',
            'region' => 'mbeya',
            'age' => 26,
            'role_id' => 1,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0002'
         ]);
        User::create([
            'firstName' => 'ceo',
            'lastName' => 'ceo',
            'email' => 'ceo@ceo.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'not married',
            'phone' => 74461133,
            'gender' => 'male',
            'street' => 'sabasaba',
            'district' => 'nyamagana',
            'region' => 'mwanza',
            'age' => 26,
            'role_id' => 2,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0001'

         ]);
        User::create([
            'firstName' => 'manager',
            'lastName' => 'manager',
            'email' => 'manager@manager.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'not married',
            'phone' => 744611319,
            'gender' => 'male',
            'street' => 'sabasaba',
            'district' => 'mbeya jiji',
            'region' => 'mbeya',
            'age' => 26,
            'role_id' => 3,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0003'

         ]);
        User::create([
            'firstName' => 'loanofficer',
            'lastName' => 'loanofficer',
            'email' => 'loanofficer@loanofficer.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'not married',
            'phone' => 744611319,
            'gender' => 'male',
            'street' => 'sabasaba',
            'district' => 'mbeya jiji',
            'region' => 'mbeya',
            'age' => 56,
            'role_id' => 4,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0004'

         ]);
        User::create([
            'firstName' => 'cashier',
            'lastName' => 'cashier',
            'email' => 'cashier@cashier.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'not married',
            'phone' => 744611319,
            'gender' => 'male',
            'street' => 'nyakahoja',
            'district' => 'mjini kati',
            'region' => 'mwanza',
            'age' => 40,
            'role_id' => 5,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0005'

         ]);
    }
}
