<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::all();
        
        return BranchResource::collection($branches);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_name' => ['required', 'string', 'max:255'],
            'branch_address' => ['required', 'string'],   
        ]);

        Branch::create($request->all());
       

        return response()->noContent();

    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $Branch)
    {
        $branches = Branch::find($Branch->id);

        return response()->json($branches);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $Branch)
    {
        $Branch->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $Branch)
    {
        $Branch->delete();

        return response()->noContent();
    }

public function validateData($request){
        return $this->$request->validate([
            'branch_name' => ['required', 'string', 'max:255'],
            'branch_address' => ['required', 'string'],
        ]);
    }
}
