<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer_Loan;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Loan_Payment;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $status = User::all('status');
        $approved_Loan = Customer_Loan::where('status','approved')->count();
        $approved_Loan = Customer_Loan::where('status','approved')->count();
        $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
        $Total_loan = Customer_Loan::sum('amount');
        $Loan_repaid = Loan_Payment::sum('amount');

        $Loans = Customer_Loan::whereHas('category', function ($query) {
            $query->where('status', 'approved');
        })
        ->get()
        ->groupBy('category.name')
        ->map(function ($loans) {
            $category = $loans->first()->category; // Get the category from the first loan in the group
            $loanCount = $loans->count();
    
            return [
                'categoryName' => $category->name,
                'start_range' => $category->start_range,
                'final_range' => $category->final_range,
                'count' => $loanCount,
            ];
        });

        return response()->json(['status' => $status, 'ongoingLoan' => $ongoing_Loan, 'approvedLoan' => $approved_Loan, 'totalLoan' => $Total_loan, 'repaidLoan' => $Loan_repaid, 'loansCategory' => $Loans]);

    }

    public function LO_index(){
        $userId = auth()->user()->id;
        $currentDate = Carbon::now();
        $customers = Customer_Loan::where('user_id', $userId)->where('payment_status', 'ongoing')->count();
        $customersWithRecordToday = Customer_Loan::where('user_id', $userId)
                                    ->where('payment_status', 'ongoing')
                                    ->whereHas('loan_payment',function ($query) use ($currentDate){
                                        $query->whereDate('created_at', $currentDate->toDateString()); 
                                    })
                                    ->count();
        $customersWithoutRecordToday = Customer_Loan::where('user_id', $userId)
                                    ->where('payment_status', 'ongoing')
                                    ->whereDoesntHave('loan_payment', function ($query) use ($currentDate) {
                                        $query->whereDate('created_at', $currentDate->toDateString());
                                    })
                                    ->count();
        $customers = Customer_Loan::where('user_id', $userId)->count();
        $loans = Customer_Loan::where('user_id', $userId)->where('status', 'approved')->get();
        $overdueLoans = $loans->filter(function ($loan) use ($currentDate) {
            
            return $currentDate->greaterThanOrEqualTo($loan->calculateDueDate());
        });

        $loan_complete = Customer_Loan::where('payment_status', 'complete')->count();

        $amountOverDues = $overdueLoans->sum('amount');

        return response()->json([
            'customer pay today' => $customersWithRecordToday,
            'customer not pay today' => $customersWithoutRecordToday,
            'overdue loans' => $overdueLoans, 'Total Customers' => $customers, 
            'customer complete loan' => $loan_complete, 
            'Total Amount OverDues' => $amountOverDues
        ]);

        
    }

    public function cashier_index(){
        $currentDate = Carbon::now();
        $customers = Customer_Loan::where('payment_status', 'ongoing')->count();
        $customersWithRecordToday = Customer_Loan::where('payment_status', 'ongoing')
                                    ->whereHas('loan_payment',function ($query) use ($currentDate){
                                        $query->whereDate('created_at', $currentDate->toDateString()); 
                                    })
                                    ->count();
        $customersWithoutRecordToday = Customer_Loan::where('payment_status', 'ongoing')
                                    ->whereDoesntHave('loan_payment', function ($query) use ($currentDate) {
                                        $query->whereDate('created_at', $currentDate->toDateString());
                                    })
                                    ->count();
        $sum_customersWithoutRecordToday = Customer_Loan::where('payment_status', 'ongoing')
                                    ->whereDoesntHave('loan_payment', function ($query) use ($currentDate) {
                                        $query->whereDate('created_at', $currentDate->toDateString());
                                    })->sum('amount');
        $sum_customersWithRecordToday = Customer_Loan::where('payment_status', 'ongoing')
                                    ->whereHas('loan_payment',function ($query) use ($currentDate){
                                        $query->whereDate('created_at', $currentDate->toDateString()); 
                                    })->sum('amount');

        $sumSales = Loan_Payment::where('created_at', $currentDate)->sum('sales');
        $sumIncome = Income::where('created_at', $currentDate)->sum('incomeAmount');
        $sumExpense = Expense::where('created_at', $currentDate)->sum('expenseAmount');
        $profit = $sumSales + $sumIncome - $sumExpense;

        return response()->json([
            'All Customers' => $customers,
            'Total Customer pay today' => $customersWithRecordToday,
            'Total Customer not pay today' => $customersWithoutRecordToday,
            'Total cash for customer pay today' => $sum_customersWithRecordToday,
            'Total cash for customer not pay today' => $sum_customersWithoutRecordToday,
            'Total profit today' => $profit
        ]);

        
    }
}
