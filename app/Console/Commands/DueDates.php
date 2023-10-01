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
            $currentDate = Carbon::now();
            // $currentDate = Carbon::createFromFormat('Y-m-d H:i:s', '2023-11-03 12:00:00');
            $dueDate = $loan->calculateDueDate(); // Calculate the due date based on your logic
            // Check if the due date has passed
            if ($currentDate->greaterThanOrEqualTo($dueDate)) {
                // Calculate the number of days between the created_at date and the due_date
                $daysDifference = $currentDate->diffInDays($dueDate);
                       
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
        }
    }

    private function executeLogicFor1To5Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.05;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor6To10Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.10;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor11To15Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.15;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor16To20Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.20;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor21To25Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.25;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor26To30Days($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.30;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }

    private function executeLogicFor31DaysAndAbove($loan)
    {
        if($loan->fine == 0){
            $amount_remain = $loan->loan_remain * 0.50;
            
            $loan->update([
                'fine' => $amount_remain
            ]);
        }
    }
}
