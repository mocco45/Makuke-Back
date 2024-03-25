<?php

namespace Database\Seeders;


use App\Models\Days;
use App\Models\Fee;
use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            ['duration' => 28],
            ['duration' => 30],
            ['duration' => 60],
            ['duration' => 90],
            ['duration' => 120],
            ['duration' => 180]
        ];

        $interest = [
            ['percent' => 20],
            ['percent' => 25],
            ['percent' => 30]
        ];

        $fee = [
            ['percent' => 0],
            ['percent' => 5],
            ['percent' => 6],
            ['percent' => 10]
        ];

        foreach($days as $day){
            Days::create($day);
        }

        foreach($interest as $t){
            Interest::create($t);
        }

        foreach($fee as $f){
            Fee::create($f);
        }
      
    }
}
