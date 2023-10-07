<?php

namespace App\Http\Controllers;

use App\Models\Customer_Loan;
use App\Models\Loan_Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        $status = User::all('status');
        $approved_Loan = Customer_Loan::where('status','approved')->count();
        $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
        $Total_loan = Customer_Loan::sum('amount');
        $Loan_repaid = Loan_Payment::sum('amount');

        return response()->json(['status' => $status, 'ongoing loan' => $ongoing_Loan, 'approved loan' => $approved_Loan, 'total loan' => $Total_loan, 'repaid loan' => $Loan_repaid]);

    }
}
