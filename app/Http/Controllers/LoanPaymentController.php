<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Customer_Loan;
use App\Models\Income;
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
        if($customer_loan->status == 'approved'){
            $principle = $customer_loan->category->interest;
            $sales = $data['amount'] * ($principle/100);

            $loanPay = Loan_Payment::create([
                'customer_loan_id' => $customer_loan->id,
                'amount' => $data['amount'],
                'type' => $data['type'],
                'sales' => $sales,
            ]);

            Income::create([
                'incomeName' => 'sales',
                'incomeDescription' => 'loan sales',
                'incomeAmount' => $sales,
                'paymentMethod' => 'both',
                'incomeDate' => $loanPay->created_at,
            ]);
            
            if($data['type'] == 'fine'){
                $payment = $customer_loan->fine - $data['amount'];

            $customer_loan->update([
                'fine_remain' => $payment
            ]);
            }
            elseif($data['type'] == 'loan'){
            
                if($customer_loan->amount == $customer_loan->loan_remain){
                    $payment = $customer_loan->amount - $data['amount'];
                }else{
                    $payment = $customer_loan->loan_remain - $data['amount'];
                }
                    $customer_loan->update([
                        'loan_remain' => $payment
                    ]);

                if($customer_loan->loan_remain == 0){
                    $customer_loan->update([
                        'payment_status' => 'complete'
                    ]);        
                } 
        
                if($customer_loan->payment_status == 'stilled'){
                    $customer_loan->update([
                        'payment_status' => 'ongoing'
                    ]);       
                }
                
                if($customer_loan->loan_remain < 0){
                    $customer_loan->update([
                        'payment_status' => 'overpaid'
                    ]);       
                }

            }

            return response()->json(["Amount {$data['amount']} paid successfully"]);
    }
    else{
            return response()->json(['Loan Payment Not Approved']);
    }

    }

    public function update(){

    }

    public function destroy(){

    }
}
