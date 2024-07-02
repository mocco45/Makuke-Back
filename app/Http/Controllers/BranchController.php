<?php

namespace App\Http\Controllers;

use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Models\Customer_Loan;
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

public function getCustomerBasedStatus(){
        $approved_Loan = Customer_Loan::where('payment_status','complete')->get();
        $ongoing_Loan = Customer_Loan::where('payment_status','ongoing')->get();
        $overpaid_Loan = Customer_Loan::where('payment_status','overpaid')->get();
        $stilled_Loan = Customer_Loan::where('payment_status','stilled')->get();

        return response()->json([
            'complete_loan' => $approved_Loan,
            'ongoing_loan' => $ongoing_Loan,
            'overpaid_loan' => $overpaid_Loan,
            'not_paid_loan' => $stilled_Loan
        ]);
}
}
