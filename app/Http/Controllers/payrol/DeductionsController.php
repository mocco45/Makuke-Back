<?php

namespace App\Http\Controllers\payrol;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deductions = Deduction::all();
        return response()->json($deductions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:'.Deduction::class],
        ]);

        Deduction::create($request->all());
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Deduction $deduction)
    {
        return response()->json($deduction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deduction $deduction)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the allowance with the new name
        $deduction->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Deduction updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deduction $deduction)
    {
        $deduction->delete();
        
        return response()->noContent();

    }
}
