<?php

namespace App\Console\Commands;

use App\Models\Balance;
use Illuminate\Console\Command;

class openingBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:opening-balance';

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
        $lastCloseRecord = Balance::get()->pluck('closing')->last();
        Balance::create([
            'opening' => $lastCloseRecord
        ]);

    }
}
