<?php

namespace App\Http\Controllers;

use App\Models\Customer_Loan;
use App\Models\Customers;
use App\Services\LoanService;
use App\Services\NextSMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{

    public function index(){
        if(auth()->user()->role_id == 4){
            $customers = Customer_Loan::where('user_id', auth()->user()->id)->with('customer','day','interest','formfee', 'customer_guarantee', 'referee', 'referee.referee_guarantee')->get();
        }
        else{
            $customers = Customer_Loan::with('customer','day','interest','formfee', 'customer_guarantee', 'referee', 'referee.referee_guarantee')->get();
        }

        return response()->json($customers);
    }

    public function show(Customers $customer){
        
        $customer_find = $customer->customer_loan()
        ->with('customer', 'day','interest','formfee', 'customer_guarantee', 'referee', 'referee.referee_guarantee')->get();
        return response()->json($customer_find);
    }

    public function store(Request $request){
        DB::beginTransaction();

        try {           
            // response($request);
            //   $request->validate([
            //     'customerImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
            // ]); 
            
        if ($request->hasFile('customerImage')) {
            $uploadedFile = $request->file('customerImage');

            $customerFileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            
            $uploadedFile->storeAs('public/images/customers', $customerFileName);
        }
        $customers = $request->customerId;

        if($customers == null){

            $newcustomer = Customers::create([
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
                    'branch_id' => auth()->user()->branch_id
                ]);
                
            $customers = $newcustomer->id;
            }
            
            $customer_id = $customers;
                
                $loanServices = app(LoanService::class);

                $loanServices->setid($customer_id);
                
                $loanServices->store($request);
            
                DB::commit();
            
                return response()->json(['Customer created successfully'] ,200);
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
            $imgpath = $img->move($destination, $name);
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
                    'image' => $imgpath,
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
