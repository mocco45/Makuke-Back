<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BalanceController extends Controller
{
    public function index(){
        $lastRecord = Balance::get()->pluck('closing')->last();
        
        Balance::create([
            'opening' => $lastRecord
        ]);
        
        return response()->json(['success response' => $lastRecord->id]);

    }

    public function store(){
        $currentDate = Carbon::now();
        $income = Income::whereDate('created_at', $currentDate->toDateString())->sum('incomeAmount');
        $expense = Expense::whereDate('created_at', $currentDate->toDateString())->sum('expenseAmount');

        $amount = $income - $expense;
        $balances = Balance::get();
        if($balances->count() == 0){
            Balance::create([
                'current' => $amount
            ]);
        }else{
            $lastRecord = Balance::get()->last();
            $lastRecord->update([
                'current' => $amount
            ]);
        }

        return response()->json([ 'successfully created balance']);
    }
}
