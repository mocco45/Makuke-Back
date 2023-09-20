<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function index(){
        $allowance_list = Allowance::all();

        return response()->json( $allowance_list);
    }

    public function store(Request $request){
        Allowance::create([
            'name' => $request->allowance
        ]);

        return response()->json(['Allowance created successfully']);
    }

    public function update(Request $request, Allowance $allowance){
        $changes = $request->all();

        $allowance->update($changes);

        return response()->json(['Allowance updated successfully']);
    }

    public function destroy(Allowance $allowance){
        $allowance->delete();

        return response()->json(['Allowance deleted successfully']);
    }

}
