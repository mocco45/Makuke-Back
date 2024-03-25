<?php

namespace App\Services;

use App\Models\Customer_Loan;
use App\Models\Days;
use App\Models\Fee;
use App\Models\Income;
use App\Models\Interest;

class LoanService 
{
    private $loanee_id;
    
    public function setid($id){
        
        $this->loanee_id = $id;

    }

    public function store($request)
    {
        
        $customer_id = $this->loanee_id;
    
        if($customer_id){
            $interest = Interest::find($request->interest)->percent;
            $duration = Days::find($request->duration)->duration;
            $formfee = Fee::find($request->formfee)->percent;
            $txtConvert = $request->loanAmount;
            $principal = (int)str_replace(',', '', $txtConvert);
            $interestRate = ($interest)/100;
            $loan_interest = $principal + ($principal * $interestRate);
            $form_fee = ($formfee * $request->principal)/100;
            
            $loan = Customer_Loan::create([
                'amount' => $loan_interest,
                'loan_remain' => $loan_interest,
                'day_id' => $request->duration,
                'interest_id' => $request->interest,
                'formfee_id' => $request->formfee,
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'customer_id' => $customer_id,
                'original' => $principal
            ]);

            // Income::create([
            //     'incomeName' => 'form fee',
            //     'incomeDescription' => 'form fee',
            //     'incomeAmount' => $form_fee,
            //     'paymentMethod' => 'any',
            //     'incomeDate' => $loan->created_at,
            // ]);
            
            $cid = $loan->id;
            $customerLoan_id = app(RefereeService::class);
            $customerLoan_id->store($request,$cid);

        }
        else{
            return response()->json(['Put Valid Loan Amount'], abort(500));
        }
        
        // Extract input data from the request
    }


}








