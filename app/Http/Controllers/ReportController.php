<?php

namespace App\Http\Controllers;

use App\Models\Customer_Loan;
use App\Models\Customers;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Loan_Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show(Request $request){
        
        if($request->reportId == 1){
            $allCustomers = Customers::count();
            $approved_Loan = Customer_Loan::where('status','approved')->count();
            $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
            $overpaid_Loan = Customer_Loan::where('payment_status','overpaid')->count();
            $stilled_Loan = Customer_Loan::where('payment_status','stilled')->count();

            return response()->json([
                'all_customers' => $allCustomers,
                'all_loan' => $approved_Loan,
                'ongoing_loan' => $ongoing_Loan,
                'overpaid_loan' => $overpaid_Loan,
                'not_paid_loan' => $stilled_Loan
            ]);
            
        }elseif($request->reportId == 2){
            $Total_loan = Customer_Loan::sum('amount');
            $Loan_repaid = Loan_Payment::sum('amount');
            $Loan_not_paid = $Total_loan - $Loan_repaid;

            return response()->json([
                'all_loan_borrowed' => $Total_loan,
                'all_loan_returned' => $Loan_repaid,
                'all_loan_not_returned' => $Loan_not_paid,
            ]);

        }elseif($request->reportId == 3){

            $allCustomers = Customers::count();
            $approved_Loan = Customer_Loan::where('status','approved')->count();
            $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
            $overpaid_Loan = Customer_Loan::where('payment_status','overpaid')->count();
            $stilled_Loan = Customer_Loan::where('payment_status','stilled')->count();
            $Total_loan = Customer_Loan::sum('amount');
            $Loan_repaid = Loan_Payment::sum('amount');
            $Loan_not_paid = $Total_loan - $Loan_repaid;

            return response()->json([
                'all_customers' => $allCustomers,
                'all_loan' => $approved_Loan,
                'ongoing_loan' => $ongoing_Loan,
                'overpaid_loan' => $overpaid_Loan,
                'not_paid_loan' => $stilled_Loan,
                'all_loan_borrowed' => $Total_loan,
                'all_loan_returned' => $Loan_repaid,
                'all_loan_not_returned' => $Loan_not_paid
            ]);
        }elseif($request->reportId == 4){

            $approved_Loan = Customer_Loan::where('status','approved')->count();
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
            
            return response()->json(['Category loans' => $Loans]);

        }elseif($request->reportId == 5){
            
            $sales = Loan_Payment::with(['customer_loan:id,amount,loan_remain,customer_id','customer_loan.customer:customer_id,firstName,lastName'])->get();

            return response()->json(['sales report' => $sales]);

        }elseif($request->reportId == 6){
            $revenue = Income::all(['incomeName', 'incomeAmount']);
            $expense = Expense::all(['expenseName', 'expenseAmount']);
            $revenueSum = Income::sum('incomeAmount');
            $expenseSum = Expense::sum('expenseAmount');

            $profit = $revenueSum - $expenseSum;

            return response()->json(['revenue' => $revenue, 'expense' => $expense, 'profit' => $profit, 'Total expense' => $expenseSum, 'Total revenue' => $revenueSum]);
            
        }elseif($request->reportId == 7){
            $expenses = Expense::all();

            return response()->json(['expenses' => $expenses]);
        }elseif($request->reportId == 8){
            $revenues = Income::all();

            return response()->json(['revenues' => $revenues]);
        }
    }

}
