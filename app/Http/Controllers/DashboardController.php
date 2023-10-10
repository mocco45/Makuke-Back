<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer_Loan;
use App\Models\Loan_Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $status = User::all('status');
        $approved_Loan = Customer_Loan::where('status','approved')->count();
        $approved_Loan = Customer_Loan::where('status','approved')->count();
        $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
        $Total_loan = Customer_Loan::sum('amount');
        $Loan_repaid = Loan_Payment::sum('amount');

        $z = Customer_Loan::where('status','approved')->with('category')->count();
        return response()->json($z);

        // return response()->json(['status' => $status, 'ongoingLoan' => $ongoing_Loan, 'approvedLoan' => $approved_Loan, 'totalLoan' => $Total_loan, 'repaidLoan' => $Loan_repaid]);

    }
}
