<?php

namespace App\Http\Controllers;

use App\Http\Resources\loanResource;
use App\Models\Customer_Loan;
use App\Models\Customers;
use App\Models\rejected_reasons;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index(){
        if(Auth::user()->role_id == 2 || Auth::user()->role_id == 1){
            $approvals = Customers::with('customer_loan')->get();
    
        return response()->json(['data' => $approvals]);
        
        }elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
        $approvals = Customers::with('customer_loan', 'customer_loan.customer_guarantee', 'customer_loan.referee', 'customer_loan.referee.referee_guarantee')->get();
    
        return response()->json(['data' => $approvals]);
        }
        
    }

    public function pending(){
        if(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
            $pending = Customer_Loan::where('status','pending')->get();
            
        }elseif(Auth::user()->role_id == 2 || Auth::user()->role_id == 1){
            $pending = Customer_Loan::where('status','manager_approved')->get();
        }
        
        return loanResource::collection($pending);
    }

    public function acceptupdate(Customer_Loan $customer_Loan){
        $loan = Customer_Loan::find($customer_Loan)->first();
        
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 1) {
            $loan->update([
                'status' => 'approved'
            ]);
    
            return response()->json(['Loan Approved']);
        } 
        elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
            $loan->update([
                'status' => 'manager_approved'
            ]);
    
            return response()->json(['Manager Approved']);
        }
        else{
            return response()->json(['Contact Admin']);
        }

    }

    public function rejectupdate(Customer_Loan $customer_Loan, Request $request){
        try {
        
        $loan = Customer_Loan::find($customer_Loan)->first();
        
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            
            $valid = $request->validate([
                'reasons' => 'required|string|max:100'
                ]);
            $rejects = rejected_reasons::create([
                'reasons' => $request->reasons,
                'customer_loan_id' => $request->customer_loan_id
            ]);
            $loan->update([
                'status' => 'rejected'
            ]);

            return response()->json(['Loan Rejected' => $rejects]);
        } 

    } catch (\Throwable $th) {
     return response()->json(['error' => $th->getMessage()]);       
    }

    }

}
