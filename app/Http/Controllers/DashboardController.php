<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Branch;
use App\Models\Customer_Loan;
use App\Models\Customers;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Loan_Payment;
use App\Models\Payment_method;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        
        if(auth()->user()->role_id == 1){
           return $this->admin();
        }
        elseif(auth()->user()->role_id == 2){
           return $this->ceo();
        }
        elseif(auth()->user()->role_id == 3){
            
           return $this->manager();
        }
        elseif(auth()->user()->role_id == 4){
           return $this->LO_index();
        }
        elseif(auth()->user()->role_id == 5){
           return $this->cashier_index();
        }
        elseif(auth()->user()->role_id == 6){

        }
    }

    public function LO_index(){
        $userId = auth()->user()->id;
        $currentDate = Carbon::now();
        $customers = Customer_Loan::where('user_id', $userId)->where('payment_status','!=', 'complete')->where('payment_status','!=', 'overpaid')->count();
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
                                    
        if(Loan_Payment::count() > 0 && Loan_Payment::whereDate('created_at', $currentDate->toDateString())->count() > 0){
            $sum_today = Customer_Loan::where('user_id', $userId)
                ->where('payment_status', 'ongoing')
                ->whereHas('loan_payment',function ($query) use ($currentDate){
                    $query->whereDate('created_at', $currentDate->toDateString()); 
                })->with(['loan_payment' => function ($query) use ($currentDate) {
                    $query->whereDate('created_at', $currentDate->toDateString());
                }])
                ->withSum('loan_payment', 'amount')
                ->first()
                ->loan_payment_sum_amount;
        }else{
            $sum_today = 0;
        }

        $amount_distributed = Customer_Loan::where('user_id', $userId)
        ->where('status', 'approved')->sum('loan_remain');

        $loans = Customer_Loan::where('user_id', $userId)->where('status', 'approved')->get();
        $overdueLoans = $loans->filter(function ($loan) use ($currentDate) {
            return $currentDate->greaterThanOrEqualTo($loan->calculateDueDate());
        });

        $count_overdueLoans = $loans->filter(function ($loan) use ($currentDate) {
            return $currentDate->greaterThanOrEqualTo($loan->calculateDueDate());
        })->count();

        $loan_complete = Customer_Loan::where('payment_status', 'complete')->count();

        $repay = Loan_Payment::whereDate('created_at', $currentDate->toDateString())->sum('amount');
        
        

        return response()->json([
            'Total_Customers' => $customers, 
            'customer_pay_today' => $customersWithRecordToday,
            'customer_not_pay_today' => $customersWithoutRecordToday,
            'overdue_loans' => $count_overdueLoans, 
            'customer_complete_loan' => $loan_complete, 
            'repay'=> $repay,
            'sumDist' => $amount_distributed,
        ]);

        
    }

    public function cashier_index(){
        $currentDate = Carbon::now();
        $branch_id = auth()->user()->branch_id;
        $customers = Customer_Loan::where('status', 'approved')->where('payment_status','!=', 'complete')
                                    ->where('payment_status','!=', 'overpaid')->where('branch_id', $branch_id)
                                    ->count();
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
        $sum_customersWithRecordToday = Customer_Loan::where('payment_status', 'ongoing')
                                    ->whereHas('loan_payment',function ($query) use ($currentDate){
                                        $query->whereDate('created_at', $currentDate->toDateString()); 
                                    })->sum('amount');

        
        $balance = Balance::where('created_at', $currentDate->toDateString())->sum('current');
        
        $cashierMedia = $this->media();

        $sumIncome = Income::where('created_at', $currentDate)->sum('incomeAmount');

        $sumExpense = Expense::where('created_at', $currentDate)->sum('expenseAmount');

        return response()->json([
            'AllCustomers' => $customers,
            'TotalCustomerPayToday' => $customersWithRecordToday,
            'TotalCustomerNotPayToday' => $customersWithoutRecordToday,
            'TotalCashForCustomerPayToday' => $sum_customersWithRecordToday,
            'sumIncome' => $sumIncome,
            'sumExpense' => $sumExpense,
            'balanceToday' => $balance 
            // 'TotalProfitToday' => $profit
        ] + $cashierMedia);

        
    }

    public function manager(){
        $currentDate = Carbon::now();
        $branch = auth()->user()->branch_id;
        $total_customer = Customers::where('branch_id', $branch)->count();
        $cust_pay = Customer_Loan::where('payment_status', 'ongoing')
        ->where('branch_id', $branch)
        ->whereHas('loan_payment', function ($query) use ($currentDate) {
            $query->whereDate('created_at', $currentDate->toDateString());
        })->count();
        
        $sum_today = Loan_Payment::whereDate('created_at', $currentDate->toDateString())->sum('amount');

        
        $cust_not_pay = Customer_Loan::where('payment_status', 'ongoing')
        ->where('branch_id', $branch)
        ->whereDoesntHave('loan_payment', function ($query) use ($currentDate) {
            $query->whereDate('created_at', $currentDate->toDateString());
        })->count();

        $cust_overdue = Customer_Loan::where('status', 'approved')->get()->filter(function ($loan) use ($currentDate) {
            return $currentDate->greaterThanOrEqualTo($loan->calculateDueDate());
            })->count();
        
        $balance = Balance::where('created_at', $currentDate->toDateString())->sum('current');

        $cashierMedia = $this->media();

        $loan_complete = Customer_Loan::where('payment_status', 'complete')->where('branch_id', $branch)->count();
        // $sumSales = Loan_Payment::where('created_at', $currentDate)->sum('sales');
        // $sumIncome = Income::where('created_at', $currentDate)->sum('incomeAmount');
        // $sumExpense = Expense::where('created_at', $currentDate)->sum('expenseAmount');
        // $profit = $sumSales + $sumIncome - $sumExpense;

        return response()->json([
            'TotalCustomers' => $total_customer,
            'TotalCustomerPayToday' => $cust_pay,
            'TotalCustomerNotPayToday' => $cust_not_pay,
            'TotalCustomerOverdue' => $cust_overdue,
            'TotalCustomerComplete' => $loan_complete,
            'sumToday' => $sum_today,
            'balance' => $balance
            // 'ProfitToday' => $profit
        ] + $cashierMedia);

        }

    public function admin(){
            $total_staff = User::count();
            $total_customer = Customers::count();
            $total_loan = Customer_Loan::count();
            $total_branch = Branch::count();

            return response()->json([
                'TotalStaff' => $total_staff,
                'TotalCustomer' => $total_customer,
                'TotalLoan' => $total_loan,
                'TotalBranches' => $total_branch
            ]);
        }

        public function ceo(){
            // $online = User::where('status', 1)->get(['firstName','lastName','status']);
            // $offline = User::where('status', 0)->get(['firstName','lastName','status']);
            $currentDate = Carbon::now();
            $total_customer = Customers::count();
            $branches = Branch::count();
            $users = User::count();
            $approved_Loan = Customer_Loan::where('status','approved')->count();
            $loan_complete = Customer_Loan::where('payment_status', 'complete')->count();
            $cust_pay = Customer_Loan::where('payment_status', 'ongoing')
                        ->whereHas('loan_payment', function ($query) use ($currentDate) {
                            $query->whereDate('created_at', $currentDate->toDateString());
                        })->count();
            $cust_not_pay = Customer_Loan::where('payment_status', 'ongoing')
                        ->whereDoesntHave('loan_payment', function ($query) use ($currentDate) {
                            $query->whereDate('created_at', $currentDate->toDateString());
                        })->count();
            // $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->count();
            $pending_Loan = Customer_Loan::where('payment_status','pending')->count();
            $amount_distributed = Customer_Loan::where('status', 'approved')->sum('amount');
            $balance = Balance::where('created_at', $currentDate->toDateString())->sum('current');
            $sumExpense = Expense::where('created_at', $currentDate)->sum('expenseAmount');
            $cashierMedia = $this->ceo_media();
    
            return response()->json([ 
                'allCustomers' => $total_customer,
                'totalBranches' => $branches,
                'totalUsers' => $users,
                'inContract' => $approved_Loan,
                'loanComplete' => $loan_complete,
                'payToday' => $cust_pay,
                'notToday' => $cust_not_pay,
                'amountdist' => $amount_distributed,
                'pendingLoan' => $pending_Loan,
                'balance' => $balance,
                'expenses' => $sumExpense
            ] + $cashierMedia);
        }

        public function media(){
            $branchID = auth()->user()->branch_id;
            $payperbranch = Branch::find($branchID)->payment_method;
            $currentDate = Carbon::now();
            $loan = Loan_Payment::whereDate('created_at', $currentDate->toDateString())->with('payment_method')->get();

            $sumrepay = [];

            foreach ($payperbranch as $method) {
                $payways = $method->payment_method; // Assuming 'name' is the attribute for payment method name
                
                $sum = $loan->where('payment_method_id', $method->id)->sum('amount');
                
                // $countin = $payperbranch->count();
                
                if ($sum > 0) {
                    $sumrepay[$payways] = $sum;
                }else{
                    $sumrepay[$payways] = 0;
                }

                // $sumrepay['count'] = $countin;

            }

            return ['media' =>$sumrepay];

        }

        public function ceo_media(){
            $branches = Branch::all();
            $currentDate = Carbon::now();
            $loan = Loan_Payment::whereDate('created_at', $currentDate->toDateString())->with('payment_method')->get();
            $sumAll = [];
            foreach($branches as $branch){
                $meth = $branch->payment_method;
                foreach($meth as $payperbranch){

                    $method = $payperbranch->payment_method; // Assuming 'name' is the attribute for payment method name
                    
                    $sum = $loan->where('payment_method_id', $payperbranch->id)->sum('amount');
                    
                    // $countin = $payperbranch->count();
                    
                    if ($sum > 0) {
                        $sumAll[$method] = $sum;
                    }else{
                        $sumAll[$method] = 0;
                    }             
                }
            }
            return ['ceo_media' =>$sumAll];

        }



}
