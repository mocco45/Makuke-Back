<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('payment_method', 'payment_type')->get();
        return response()->json($expenses);
        // return ExpenseResource::collection($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expenseDescription' => 'nullable|string|max:255',
            'expenseAmount' => 'required',
            'payment_type_id' => ['required'],
            'payment_method_id' => ['required'],
            'expenseDate' => 'required|date',
        ]);

        Expense::create([
            'payment_method_id' => $request->payment_method_id,
            'payment_type_id' => $request->payment_type_id,
            'account_name_id' => $request->account_name_id,
            'account_category_id' => $request->account_category_id,
            'expenseDescription' => $request->expenseDescription,
            'expenseAmount' => $request->expenseAmount,
            'expenseDate' => $request->expenseDate
        ]);
        return response()->json(['Expense Registered successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validatedData = $request->validate([
            'expenseName' => 'string|max:255',
            'expenseDescription' => 'nullable|string|max:255',
            'expenseAmount' => 'numeric|min:0',
            'paymentMethod' => ['nullable'],
            'expenseDate' => 'nullable'
        ]);

        $expense->update($validatedData);

        return response()->json(['updated expenses successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json(['Expense deleted successfully']);

    }
}
