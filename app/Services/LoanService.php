<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Customer_Loan;
use Illuminate\Support\Facades\Request;

class LoanService 
{
    private $loanee_id;
    
    public function setid($id){
        
        $this->loanee_id = $id;

    }

    public function store($request)
    {
        
        $customer_id = $this->loanee_id;
        $amount = $request->loanAmount;
        $category = Category::where('start_range', '<=', $amount)
                    ->where('final_range', '>=', $amount)->first();

        if($category){

            $loan = Customer_Loan::create([
                'amount' => $request->loanAmount,
                'loan_remain' => $request->loanAmount,
                'repayment_time' => $category->duration,
                'interest_rate' => $category->interest,
                'user_id' => auth()->user()->id,
                'branch_id' => auth()->user()->branch_id,
                'category_id' => $category->id,
                'customer_id' => $customer_id
            ]);
            $cid = $loan->id;
            $customerLoan_id = app(RefereeService::class);
            $customerLoan_id->store($request,$cid);

            $principal = $request->amount;
        $interestRate = $category->interest;
        $repaymentTime = $category->duration;

        if($category->name !== 'super'){

             ($principal * $interestRate * pow((1 + $interestRate),$repaymentTime))/(pow((1 + $interestRate),$repaymentTime)-1);

            return "successfully For";
        }
        elseif($category->name == 'super'){
             $principal + ($principal * 0.3);

            return "Successfully For Super Loan";
        }

        else{
            return "No Package Selected";
        }

        }
        else{
            return response()->json(['Put Valid Loan Amount'], abort(500));
        }
        
        // Extract input data from the request
    }


}








