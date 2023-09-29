<?php

namespace App\Console\Commands;

use App\Models\Customer_Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CalculateDueDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loans:calculate-due-dates';

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
        echo 'here here';
    }
    //     $dueDateRanges = [
    //         [1, 5],
    //         [6, 10],
    //         [11, 15],
    //         [16, 20],
    //         [21, 25],
    //         [26, 30],
    //         [31, null], // 31 days and above
    //     ];
    //     foreach ($dueDateRanges as [$minDays, $maxDays]) {
    //         $loans = Customer_Loan::all(); // Fetch all loans

    //         foreach ($loans as $loan) {
    //             // Retrieve the due_date_start_months value from the database for this loan
    //             $dueDateStartMonths = $loan->repayment_time;

    //             // Calculate the due date with the appropriate due_date_start_months value
    //             $dueDate = now()->addMonths($dueDateStartMonths)->addDays($minDays);

    //             // Check if the due date falls within the current range
    //             if ($maxDays !== null && $dueDate->lte(now()->addMonths($dueDateStartMonths)->addDays($maxDays)->endOfDay())) {
    //                 // Perform logic for this group
    //                 $this->executeLogicForDueDateRange($loan, $minDays, $maxDays);
    //             } elseif ($maxDays === null) {
    //                 // Perform logic for loans with 31 days and above due dates
    //                 $this->executeLogicForDueDateRange($loan, $minDays, null);
    //             }
    //         }
    //     }

    // }

    // private function executeLogicForDueDateRange($loan, $minDays, $maxDays)
    // {
    //     // Implement your logic for each due date range here
    //     if ($minDays === null) {
    //         $this->info("Loan ID {$loan->id}: Processing for 31 days and above.");
    //         echo "Hello world!";
    //     } else {
    //         $this->info("Loan ID {$loan->id}: Processing for {$minDays}-{$maxDays} days.");
    //         // Execute specific logic for this group
    //     }
    // }
}