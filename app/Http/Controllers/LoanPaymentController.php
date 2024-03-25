<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Customer_Loan;
use App\Models\Income;
use App\Models\Loan_Payment;
use App\Services\NextSMSService;

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
            Loan_Payment::create([
                'customer_loan_id' => $customer_loan->id,
                'amount' => $data['amount'],
                'payment_type_id' => $data['type'],
                'payment_method_id' => $data['method']
            ]);
            
                if($customer_loan->amount == $customer_loan->loan_remain){
                    $payment = $customer_loan->amount - $data['amount'];
                }else{
                    $payment = $customer_loan->loan_remain - $data['amount'];
                }
                    $pay = $customer_loan->update([
                        'loan_remain' => $payment
                    ]);
                // if($pay){
                //     try {
                //         $amountReceived = $data['amount'];
                //         $recipient = $customer_loan->user->firstName.' '.$customer_loan->user->lastName;
                //         $loanRemain = $customer_loan->loan_remain;
                //         $phone = $customer_loan->customer->phone;
                //         $contact = '0'.$customer_loan->user->phone;
                //         $sendin = new NextSMSService();
                //         $message = $sendin->generateReceiptMessage($amountReceived, $recipient, $loanRemain, $contact);
                
                //         $response = $sendin->sendSMS($phone, $message);

                //         echo $response;
                
                //     } catch (\Throwable $th) {
                //         return response()->json(['Error occurred', 'error' => $th->getMessage()], 500);
                //     }
                // }
                // else{
                //     echo 'There is error in sms payment';
                // }

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
