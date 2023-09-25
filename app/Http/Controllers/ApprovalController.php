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
            $approvals = Customer_Loan::with('customer')->get();
    
        return response()->json(['data' => $approvals]);
        
        }elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
        $approvals = Customer_Loan::with('customer', 'customer_guarantee', 'referee', 'referee.referee_guarantee')->get();
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
    
    public function showPending(Customer_Loan $customer_Loan){
        if(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){

            $pending = Customer_Loan::find($customer_Loan->id)::where('status','pending')->first();
            
        }elseif(Auth::user()->role_id == 2 || Auth::user()->role_id == 1){
            $pending = Customer_Loan::find($customer_Loan->id)::where('status','manager_approved')->first();
        }
        
        return new loanResource($pending);
    }

    public function rejected(){
        if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1){
            $reject = Customer_Loan::where('status','rejected')->with('customer','customer_guarantee', 'referee', 'referee.referee_guarantee', 'rejected_reasons')->get();
            
            return response()->json($reject);
        }
    }

    public function ongoing(){
        $loan = Customer_Loan::where('status','approved')->get();
        return loanResource::collection($loan);
    }

    public function acceptupdate(Customer_Loan $customer_Loan){
        $loan = Customer_Loan::find($customer_Loan)->first();
        
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 1) {
            $loan->update([
                'status' => 'APPROVED'
            ]);
    
            return response()->json(['Loan Approved']);
        } 
        elseif(Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
            $loan->update([
                'status' => 'MANAGER_APPROVED'
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
            
            $request->validate([
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
