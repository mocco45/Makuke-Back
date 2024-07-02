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
        if(Auth::user()->role_id == 3 || Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $pending = Customer_Loan::where('status','pending')->get();
            
        }elseif(Auth::user()->role_id == 2 || Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $pending = Customer_Loan::where('status','processing')->orwhere('status', 'pending')->get();
        }
        
        return loanResource::collection($pending);
    }
    
    public function showPending(Customer_Loan $customer_Loan){
        $userRoleId = Auth::user()->role_id;
    
        $allowedRoles = [1, 2, 3, 5];
    
        if (in_array($userRoleId, $allowedRoles)) {
            $pending = Customer_Loan::whereIn('status', ['pending', 'processing', 'approved'])
                ->with('branch.payment_type', 'branch.payment_method')->find($customer_Loan->id);
            
        }
        
        return new loanResource($pending ?? null);
    }
    

    public function rejected(){
        $reject = Customer_Loan::where('status','rejected')->with('customer','customer_guarantee', 'referee', 'referee.referee_guarantee', 'rejected_reasons')->get();
        return response()->json($reject);
    }

    public function ongoing(){
        $loan = Customer_Loan::where('status','approved')->get();
        
        return loanResource::collection($loan);
    }

    public function acceptupdate(Customer_Loan $customer_Loan){
        $loan = Customer_Loan::find($customer_Loan->id);
    
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 1 || Auth::user()->role_id == 3 ) {
            if((Auth::user()->role_id == 2 && $loan->status == 'processing') || (Auth::user()->role_id == 3 && $loan->amount <= 500000)){
                $loan->update([
                    'status' => 'approved'
                ]);

                return response()->json(['Loan Approved']);
            }
            elseif(Auth::user()->role_id == 3){
                $loan->update([
                    'status' => 'processing'
                ]);

                return response()->json(['processing']);
            }
            else{
                return response()->json(['Contact Manager!!']);
            }
        } 
        else{
            return response()->json(['Contact Admin']);
        }

    }

    public function rejectupdate(Customer_Loan $customer_Loan, Request $request){
        try {
        
        $loan = Customer_Loan::get()->find($customer_Loan);
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3) {
            
            $request->validate([
                'reasons' => 'required|string|max:100'
                ]);
            $rejects = rejected_reasons::create([
                'reasons' => $request->reasons,
                'customer_loan_id' => $loan->id
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

    public function complete(){
        $loan = Customer_Loan::where('status','approved')->where('payment_status','complete')->get();
        
        return loanResource::collection($loan);
    }

    public function overpay(){
        $loan = Customer_Loan::where('status','approved')->where('payment_status','overpaid')->get();
        
        return loanResource::collection($loan);
    }

    public function stilled(){
        $loan = Customer_Loan::where('status','approved')->where('payment_status','stilled')->get();
        
        return loanResource::collection($loan);
    }

}
