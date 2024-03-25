<?php

namespace App\Console\Commands;

use App\Models\Balance as ModelsBalance;
use App\Models\Income;
use Illuminate\Console\Command;
use Carbon\Carbon;

class Balance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('hello world');
        $currentDate = Carbon::now();
        $income = Income::whereDate('created_at', $currentDate->toDateString())->sum('incomeAmount');
        $balances = ModelsBalance::get();
        if($balances->count() == 0){
            ModelsBalance::create([
                'closing' => $income
            ]);
        }else{
            $lastRecord = ModelsBalance::get()->last();
            $lastRecord->update([
                'closing' => $income
            ]);
        }
        
        return 0;
    }
}
