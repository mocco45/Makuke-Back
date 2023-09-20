<?php

namespace App\Http\Controllers;

use App\Http\Resources\StaffResource;
use App\Models\Accomodations;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(){
        $staffs = User::all();
        return StaffResource::collection($staffs);
    }

    public function show(User $user){
        $staff = User::find($user->id);
        return new StaffResource($staff);
    }

    public function allowance_store(User $user, Request $request){
        try {
            $request->validate([
                'type' => 'required|string|max:20',
                'amount' => 'required|numeric'
            ]);

            Payroll::create([
                'name' => 'allowance',
                'type' => $request->type,
                'amount' => $request->amount,
                'on_charge' => auth()->user()->id,
                'user_id' => $user->id,
            ]);
            
            $isNull = Accomodations::where('user_id', $user->id)->first();

            if($isNull){
                $sum = $isNull->total_allowance + $request->amount;
                $overall = $isNull->overall_amount + $request->amount;
                $valid = $isNull->update([
                    'total_allowance'=> $sum,
                    'overall_amount'=> $overall,
                ]);

                return response()->json('Accomodations updated successfully');
            }else{
                Accomodations::create([
                    'total_allowance'=> $request->amount,
                    'overall_amount'=> $request->amount,
                    'user_id' => $user->id
                ]);

                return response()->json('Accomodations created successfully');
            }
            
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function deduction_store(User $user, Request $request){
        try {
            $request->validate([
                'type' => 'required|string|max:20',
                'amount' => 'required|numeric'
            ]);

            Payroll::create([
                'name' => 'deduction',
                'type' => $request->type,
                'amount' => $request->amount,
                'on_charge' => auth()->user()->id,
                'user_id' => $user->id,
            ]);
            $isNull = Accomodations::where('user_id', $user->id)->first();

            if($isNull){
                $sum = $isNull->total_deduction + $request->amount;
                $overall = $isNull->overall_amount - $request->amount;
                $isNull->update([
                    'total_deduction'=> $sum,
                    'overall_amount'=> $overall,
                ]);

                return response()->json('Deduction updated successfully');
            }else{
                Accomodations::create([
                    'total_deduction'=> $request->amount,
                    'overall_amount'=> $request->amount,
                    'user_id' => $user->id
                ]);

                return response()->json('Deduction created successfully');
            }
            
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    
}
