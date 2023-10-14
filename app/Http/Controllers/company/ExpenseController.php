<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::all();
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'expenseName' => 'required|string|max:255',
            'expenseDescription' => 'nullable|string|max:255',
            'expenseAmount' => 'required|numeric|min:0',
            'paymentMethod' => ['required'],
            'expenseDate' => 'required|date',
        ]);

        Expense::create([
            'expenseName' => $request->expenseName,
            'expenseDescription' => $request->expenseDescription,
            'expenseAmount' => $request->expenseAmount,
            'paymentMethod' => $request->paymentMethod,
            'expenseDate' => $request->expenseDate,
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
