<?php

namespace App\Http\Controllers;

use App\Models\Days;
use App\Models\Fee;
use App\Models\Interest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index_days(){
        $days = Days::all();

        return response()->json($days, 200); 
    }

    public function index_interest(){
        $interest = Interest::all();

        return response()->json($interest, 200); 
    }

    public function index_form_fee(){
        $fees = Fee::all();

        return response()->json($fees, 200); 
    }

    public function show_days(Days $days){
        $dayFind = Days::find($days->id);
        
        return response()->json($dayFind, 200);
    }

    public function show_interest(Interest $interest){
        $findInterest = Interest::find($interest->id);
        
        return response()->json($findInterest, 200);
    }

    public function show_form_fee(Fee $fee){
        $feeFind = Fee::find($fee->id);
        
        return response()->json($feeFind, 200);
    }

    public function store_days(Request $request){
        Days::create(['duration' => $request->days]);

        return response()->json(['Day Created Successfully']);
    }

    public function store_interest(Request $request){
        Interest::create(['percent' => $request->interest]);

        return response()->json(['Interest Created Successfully']);
    }

    public function store_form_fee(Request $request){
        Fee::create(['amount' => $request->formFee]);

        return response()->json(['Form Fee Created Successfully']);
    }

    public function destroy_day(Days $day){

        $del = $day->delete();

        if($del){
            return response()->json(['Day Deletion Successfully']);
        }
        else{
            return response()->json(['Day Deletion Failed']);
        }
    }

    public function destroy_interest(Interest $interest){

        $del = $interest->delete();

        if($del){
            return response()->json(['Interest Deletion Successfully']);
        }
        else{
            return response()->json(['Interest Deletion Failed']);
        }
    }

    public function destroy_formfee(Fee $fee){

        $del = $fee->delete();

        if($del){
            return response()->json(['Form Fee Deletion Successfully']);
        }
        else{
            return response()->json(['Form Fee Deletion Failed']);
        }
    }
}
