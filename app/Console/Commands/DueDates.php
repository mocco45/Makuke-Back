<?php

namespace App\Console\Commands;

use App\Models\Customer_Loan;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DueDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:due-dates';

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
        $loans = Customer_Loan::all(); 
        foreach($loans as $loan){
        
            // $currentDate = Carbon::now();
            $currentDate = Carbon::now();
            $dueDate = $loan->calculateDueDate(); // Calculate the due date based on your logic
            // Check if the due date has passed

            if ($currentDate->greaterThanOrEqualTo($dueDate)) {
                // Calculate the number of days between the created_at date and the due_date
                $daysDifference = $loan->created_at->diffInDays($dueDate);
    
                // Check which due date range this loan falls into and execute the corresponding logic
                if ($daysDifference >= 1 && $daysDifference <= 5) {
                    $this->executeLogicFor1To5Days($loan);
                } elseif ($daysDifference >= 6 && $daysDifference <= 10) {
                    $this->executeLogicFor6To10Days($loan);
                } elseif ($daysDifference >= 11 && $daysDifference <= 15) {
                    $this->executeLogicFor11To15Days($loan);
                } elseif ($daysDifference >= 16 && $daysDifference <= 20) {
                    $this->executeLogicFor16To20Days($loan);
                } elseif ($daysDifference >= 21 && $daysDifference <= 25) {
                    $this->executeLogicFor21To25Days($loan);
                } elseif ($daysDifference >= 26 && $daysDifference <= 30) {
                    $this->executeLogicFor26To30Days($loan);
                } elseif ($daysDifference >= 31) {
                    $this->executeLogicFor31DaysAndAbove($loan);
                }
            }
            else{
                echo 'due date is not passed';
            }
        }
    }

    private function executeLogicFor1To5Days($loan)
    {
        
        $this->info("Loan ID {$loan->id}: Processing for 1-5 days due date range.");
        
    }

    private function executeLogicFor6To10Days($loan)
    {
        // Logic for loans with 6-10 days due date range
        $this->info("Loan ID {$loan->id}: Processing for 6-10 days due date range.");
        // Execute specific logic for this group
    }

    private function executeLogicFor11To15Days($loan)
    {
        // Logic for loans with 11-15 days due date range
        $this->info("Loan ID {$loan->id}: Processing for 11-15 days due date range.");
        // Execute specific logic for this group
    }

    private function executeLogicFor16To20Days($loan)
    {
        // Logic for loans with 16-20 days due date range
        $this->info("Loan ID {$loan->id}: Processing for 16-20 days due date range.");
        // Execute specific logic for this group
    }

    private function executeLogicFor21To25Days($loan)
    {
        // Logic for loans with 21-25 days due date range
        $this->info("Loan ID {$loan->id}: Processing for 21-25 days due date range.");
        // Execute specific logic for this group
    }

    private function executeLogicFor26To30Days($loan)
    {
        // Logic for loans with 26-30 days due date range
        $this->info("Loan ID {$loan->id}: Processing for 26-30 days due date range.");
        // Execute specific logic for this group
    }

    private function executeLogicFor31DaysAndAbove($loan)
    {
        // Logic for loans with 31 days and above due date range
        $this->info("Loan ID {$loan->id}: Processing for 31 days and above due date range.");
        // Execute specific logic for this group
    }
}
