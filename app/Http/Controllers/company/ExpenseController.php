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

        Expense::create($request->all());
        return response()->noContent();
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
            'expenseName' => 'required|string|max:255',
            'expenseDescription' => 'nullable|string|max:255',
            'expenseAmount' => 'required|numeric|min:0',
            'paymentMethod' => ['required'],
            // Add more validation rules for other fields if needed
        ]);

        // Update the expense record with the validated data
        $expense->update($validatedData);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->noContent();

    }
}
