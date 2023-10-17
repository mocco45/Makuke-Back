<?php

namespace Database\Seeders;

use App\Models\User;
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
            'firstName' => 'ADMIN',
            'lastName' => 'ADMIN',
            'email' => 'admin@admin.com',
            'username' => 'admin225',
            'password' => Hash::make('password'),
            'maritalStatus' => 'NOT MARRIED',
            'phone' => 744611319,
            'gender' => 'MALE',
            'street' => 'SABASABA',
            'district' => 'MBEYA JIJI',
            'region' => 'MBEYA',
            'age' => 26,
            'role_id' => 1,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0002'
         ]);
        User::create([
            'firstName' => 'CEO',
            'lastName' => 'CEO',
            'email' => 'ceo@ceo.com',
            'username' => 'ceo225',
            'password' => Hash::make('password'),
            'maritalStatus' => 'NOT MARRIED',
            'phone' => 74461133,
            'gender' => 'MALE',
            'street' => 'SABASABA',
            'district' => 'nyamagana',
            'region' => 'mwanza',
            'age' => 26,
            'role_id' => 2,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0001'

         ]);
        User::create([
            'firstName' => 'MANAGER',
            'lastName' => 'MANAGER',
            'email' => 'manager@manager.com',
            'username' => 'manager225',
            'password' => Hash::make('password'),
            'maritalStatus' => 'NOT MARRIED',
            'phone' => 744611319,
            'gender' => 'MALE',
            'street' => 'SABASABA',
            'district' => 'MBEYA JIJI',
            'region' => 'MBEYA',
            'age' => 26,
            'role_id' => 3,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0003'

         ]);
        User::create([
            'firstName' => 'LOANOFFICER',
            'lastName' => 'LOANOFFICER',
            'username' => 'loanofficer225',
            'email' => 'loanofficer@loanofficer.com',
            'password' => Hash::make('password'),
            'maritalStatus' => 'NOT MARRIED',
            'phone' => 744611319,
            'gender' => 'MALE',
            'street' => 'SABASABA',
            'district' => 'MBEYA JIJI',
            'region' => 'MBEYA',
            'age' => 56,
            'role_id' => 4,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0004'

         ]);
        User::create([
            'firstName' => 'CASHIER',
            'lastName' => 'CASHIER',
            'email' => 'cashier@cashier.com',
            'username' => 'cashier225',
            'password' => Hash::make('password'),
            'maritalStatus' => 'NOT MARRIED',
            'phone' => 744611319,
            'gender' => 'MALE',
            'street' => 'NYAKAHOJA',
            'district' => 'MJINI KATI',
            'region' => 'MWANZA',
            'age' => 40,
            'role_id' => 5,
            'branch_id' => 1,
            'financials_id' => 1,
            'staff_id' => 'M/2023/0005'

         ]);
    }
}
