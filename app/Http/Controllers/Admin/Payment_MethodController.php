<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Payment_method;
use Illuminate\Http\Request;

class Payment_MethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment = Payment_method::all();
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
        $res = Payment_method::create([
            'payment_method' => $request->method,
            'type' => $request->type
        ]);

        if($res){

            return response()->json('Successfully Payment Method Created');
        }else{
            return response()->json('Failed Payment Method Creation');
        }
    }

    public function perbranch(Request $request, Branch $Branch)
    {
        try {
            $Branch->payment_method()->attach([$request->method]);
            $assigned = Payment_method::find($request->method);
            return response()->json("Successfully assign $assigned->payment_method payment method to $Branch->branch_name branch");
        } catch (\Throwable $th) {
            return response()->json("Failed to assign $request->method reason: " . $th);
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
    public function update(Request $request, Payment_Method $Payment_Method)
    {
        $Payment_Method->update([
            'payment_method' => $request->method
        ]);

        return response()->json(['Successfully Update Payment Method']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment_Method $payment_method)
    {
       $del = $payment_method->delete();
       if($del){
        return response()->json(['Successfully Payment Method is deleted']);
       }else{
        return response()->json(['Failed Deleting Payment Method']);
       }
    }
}
