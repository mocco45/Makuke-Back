<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\Customers;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{

    public function index(){
        $customers = Customers::with('customer_loan', 'customer_loan.customer_guarantee', 'customer_loan.referee', 'customer_loan.referee.referee_guarantee')->get();
        
        return response()->json($customers);
    }

    // public function index(){
    //     $customers = Customers::with('customer_loan', 'customer_loan.customer_guarantee', 'customer_loan.referee', 'customer_loan.referee.referee_guarantee')->get();
        
    //     // Modify the data structure to convert customer_guarantee to an object for each customer_loan
    //     $customers->transform(function ($customer) {
    //         $customer->customer_loan->each(function ($loan) {
    //             $loan->customer_guarantee = $loan->customer_guarantee->first();
    //         });
    //         return $customer;
    //     });
    
    //     return response()->json($customers);
    // }
    

    public function show(Customers $customer){
        
        $customer_find = Customers::find($customer->id)::with('customer_loan', 'customer_loan.customer_guarantee', 'customer_loan.referee', 'customer_loan.referee.referee_guarantee')->first();;

        return response()->json($customer_find);
    }

    public function store(Request $request){

        try {

        if($request->status == "approved"){

        }            

            DB::beginTransaction();

            // // Validate the uploaded file
              $request->validate([
                'customerImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]); 
            // Store the uploaded file
          
        if ($request->hasFile('customerImage')) {
            $uploadedFile = $request->file('customerImage');

            $customerFileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/images/customers', $customerFileName);
        }
                
            $customer = Customers::create([
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'otherName' => $request->otherName,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'marital_status' => $request->maritalStatus,
                    'phone' => $request->phone,
                    'nida' => $request->nida,
                    'occupation' => $request->occupation,
                    'region' => $request->region,
                    'district' => $request->district,
                    'street' => $request->street,
                    'photo' => $customerFileName,
                ]);

                $customer_id = $customer->id;
                
                $loanServices = app(LoanService::class);

                $loanServices->setid($customer_id);
                
                $loanServices->store($request);
            
                DB::commit();
            
                return response()->json(['Customer created successfully'],200);
    } catch (\Throwable $th) {
        DB::rollBack();
        return response()->json(['Error occured', 'error' => $th->getMessage() .' '.$th],500);
    }

        
    }

    public function edit(Customers $customer){
        $customer_find = Customers::find($customer->id);

        return response()->json(['edit-customer' => $customer_find]);
    }

    public function update(Request $request, Customers $customer){
        try {
       
        if($request->hasFile('image')){
            $img = $request->file('image');
            $name = $img->getClientOriginalName();
            $destination = public_path('images/Customer');
            $img->move($destination, $name);
        }

        $customers = Customers::find($customer->id);
        $name = $request->file('image')->getClientOriginalName();
        $customers->update([
                    'firstName' => $request->firstName,
                    'lastName' => $request->lastName,
                    'otherName' => $request->otherName,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'marital_status' => $request->marital_status,
                    'phone' => $request->phone,
                    'occupation' => $request->occupation,
                    'region' => $request->region,
                    'district' => $request->district,
                    'street' => $request->street,
                    'image' => $name,
        ]);
    

        return response()->json(['Customer update successfully'],200);
             //code...
            } catch (\Throwable $th) {
                return response()->json(['Error occured', 'error' => $th->getMessage()],500);
            }

    }

    public function destroy(Customers $customer){
        if(Auth::user()->id == $customer->id){
            return response()->json(['Access Denied'], abort(401));
        }

        $customer_del = $customer->delete();

        
        if($customer_del){
            unlink(public_path('Images/Customer/' . $customer->image ));
        }

        return response()->json(['Customer Delete Successfully']);
    }

    
}
