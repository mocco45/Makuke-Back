<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Models\AccountCategories;
use App\Models\Balance;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $incomes = Income::with('payment_method', 'payment_type')->get();
        return response()->json($incomes);
        // return IncomeResource::collection($incomes);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'incomeDescription' => 'nullable|string|max:255',
            'incomeAmount' => 'required|string',
            'payment_type_id' => ['required'],
            'payment_method_id' => ['required'],
            'account_name_id' => ['required'],
            'account_category_id' => ['required'],
            'incomeDate' => 'required|date', 
        ]);

       Income::create([
            'payment_method_id' => $request->payment_method_id,
            'payment_type_id' => $request->payment_type_id,
            'incomeDescription' => $request->incomeDescription,
            'incomeAmount' => $request->incomeAmount,
            'incomeDate' => $request->incomeDate,
            'account_name_id' => $request->account_name_id,
            'account_category_id' => $request->account_category_id
        ]);

        return response()->json(['Revenue Registered successfully']);
    }

    public function index_income(Request $request){
        
        $incomes = Income::selectRaw('account_name_id, SUM(incomeAmount) as total_amount')
                    ->whereBetween('incomeDate', [$request->minDate, $request->maxDate])
                    ->with('account_name', 'account_category')
                    ->groupBy('account_name_id')
                    ->get();

        $expenses = Expense::selectRaw('account_name_id, SUM(expenseAmount) as total_amount')
                    ->whereBetween('expenseDate', [$request->minDate, $request->maxDate])
                    ->with('account_name', 'account_category')
                    ->groupBy('account_name_id')
                    ->get();

        $incomesExpenses['incomes'] = $incomes->map(function ($income){
                        return [
                            'amount' => $income->total_amount,
                            'code' =>  $income->account_name->code,
                            'name' =>  $income->account_name->name,
                            'type' => 'income'
                        ];
                    });
                    
        $incomesExpenses['expenses'] = $expenses->map(function ($expense){
                        return [
                            'amount' => $expense->total_amount,
                            'code' =>  $expense->account_name->code,
                            'name' =>  $expense->account_name->name,
                            'type' => 'expense'
                        ];
                    });;
                    
        // $incomesAndExpenses = $incomes->concat($expenses)->map(function ($transaction) {
        //                 return [
        //                     'amount' => $transaction->total_amount,
        //                     'code' => $transaction->account_name->code,
        //                     'name' => $transaction->account_name->name,
        //                 ];
        //             });
                    

        return $incomesExpenses;
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        return response()->json($income);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $validatedData = $request->validate([
            'incomeDate' => 'nullable',
            'incomeName' => 'string|max:255',
            'incomeDescription' => 'nullable|string|max:255',
            'incomeAmount' => 'string',
            'paymentMethod' => ['nullable'],
            // Add more validation rules for other fields if needed
        ]);

        // Update the income record with the validated data
        $income->update($validatedData);

        return response()->json(['updated expenses successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();
        
        return response()->json(['Revenue deleted successfully']);

    }
}