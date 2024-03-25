<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Payment_type;
use Illuminate\Http\Request;

class Payment_TypeController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment = Payment_type::all();
        return response()->json($payment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $res = Payment_type::create([
            'payment_type' => $request->type
        ]);

        if($res){

            return response()->json('Successfully Payment Type Created');
        }else{
            return response()->json('Failed Payment Type Creation');
        }
    }

    public function perbranch(Request $request, Branch $Branch)
    {
        if ($Branch->payment_type()->where('payment_type_id', $request->type)->exists()) {
            return response()->json(['message' => 'The assigned payment type already exists for this branch'], 400);
        }else{
            try {
                $Branch->payment_type()->attach([$request->type]);
                $assigned = Payment_type::find($request->type);
                return response()->json("Successfully assign $assigned->payment_type payment type to $Branch->branch_name branch");
            } catch (\Throwable $th) {
                return response()->json("Failed to assign $request->type reason: " . $th);
            }
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment_type $Payment_Type)
    {
        $Payment_Type->update([
            'payment_type' => $request->type
        ]);

        return response()->json(['Successfully Update Payment Type']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment_type $payment_type)
    {
       $del = $payment_type->delete();
       if($del){
        return response()->json(['Successfully Payment Type is deleted']);
       }else{
        return response()->json(['Failed Deleting Payment Type']);
       }
    }
}
