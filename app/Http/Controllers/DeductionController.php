<?php

namespace App\Http\Controllers;

use App\Models\Deduction;
use Illuminate\Http\Request;

class DeductionController extends Controller
{
    public function index(){
        $deduction_list = Deduction::all();

        return response()->json( $deduction_list);
    }

    public function store(Request $request){
        Deduction::create([
            'name' => $request->name
        ]);

        return response()->json(['Deduction created successfully']);
    }

    public function update(Request $request, Deduction $deduction){
        $changes = $request->all();

        $deduction->update($changes);

        return response()->json(['Deduction updated successfully']);
    }

    public function destroy(Deduction $deduction){
        $deduction->delete();

        return response()->json(['Deduction deleted successfully']);
    }
}
