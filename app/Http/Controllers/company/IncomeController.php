<?php

namespace App\Http\Controllers\company;

use App\Http\Controllers\Controller;
use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $incomes = Income::all();
        return response()->json($incomes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'incomeName' => 'required|string|max:255',
            'incomeDescription' => 'nullable|string|max:255',
            'incomeAmount' => 'required|numeric|min:0',
            'paymentMethod' => ['required'],
            'incomeDate' => 'required|date', 
        ]);

        Income::create($request->all());
        return response()->noContent();
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
            'incomeDate' => 'required',
            'incomeName' => 'required|string|max:255',
            'incomeDescription' => 'nullable|string|max:255',
            'incomeAmount' => 'required|numeric|min:0',
            'paymentMethod' => ['required'],
            // Add more validation rules for other fields if needed
        ]);

        // Update the income record with the validated data
        $income->update($validatedData);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();
        
        return response()->noContent();

    }
}