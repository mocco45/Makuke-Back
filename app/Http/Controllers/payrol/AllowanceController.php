<?php

namespace App\Http\Controllers\payrol;

use App\Http\Controllers\Controller;
use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allowances = Allowance::all();
        return response()->json($allowances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:'.Allowance::class],
        ]);

        Allowance::create($request->all());
        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Allowance $allowance)
    {
        return response()->json($allowance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allowance $allowance)
    {
        // try {
            // Validate the incoming request data
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            // Update the allowance with the new name
            $allowance->update([
                'name' => $request->input('name'),
            ]);
    
            return response()->json(['message' => 'Allowance updated successfully'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'An error occurred while updating the allowance'], 500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allowance $allowance)
    {
        $allowance->delete();
        
        return response()->noContent();

    }
}
