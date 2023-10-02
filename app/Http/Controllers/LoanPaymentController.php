<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Customer_Loan;
use App\Models\Loan_Payment;


class LoanPaymentController extends Controller
{
    public function index(){
        $payments = Loan_Payment::all();

        return response()->json($payments);
    }

    public function show(Customer_Loan $customer_loan){
        $payment = $customer_loan->with('loan_payment')->get();

        return response()->json([$payment]);
    }

    public function store(PaymentRequest $request, Customer_Loan $customer_loan){
        $data = $request->validated();

        Loan_Payment::create([
            'customer_loan_id' => $customer_loan->id,
            'amount' => $data['amount'],
            'type' => $data['type']
        ]);
        if($data['type'] == 'fine'){
            $payment = $customer_loan->fine - $data['amount'];

        $customer_loan->update([
            'fine_remain' => $payment
        ]);
        }
        elseif($data['type'] == 'loan'){

        $payment = $customer_loan->amount - $data['amount'];

        $customer_loan->update([
            'loan_remain' => $payment
        ]);

        }

        return response()->json(["Amount {$data['amount']} paid successfully"]);

    }

    public function update(){

    }

    public function destroy(){

    }
}
