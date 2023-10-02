<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffResource;
use App\Models\Financials;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller

{ 
    

    public function index()
    {
        $staffs = User::all();

        return StaffResource::collection($staffs);
    }

    public function uploadStaffImage(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            // Store the uploaded file
            $uploadedFile = $request->file('file');
            $staffImageName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/images/staffs', $staffImageName);

            // Pass the $staffImageName to the store function
            


            return $staffImageName;
          

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'street' => ['required', 'string'],
            'district' => ['required', 'string'],
            'region' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'maritalStatus' => ['required', 'string'],
            'basicSalary' => ['required', 'integer'],
            'bankAccount' => ['required', 'integer'],
            'bankAccountHolderName' => ['required', 'string', 'max:255'],
            'bankName' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            // 'photo' => ['nullable|image|mimes:jpeg,png,jpg,gif|max:2048'],
            'password' => ['required'],
        ]);
        // $imageName = time().'.'.$request->photo->getClientOriginalExtension();
        // $request->image->move(public_path('images'), $imageName);

          // Store the uploaded file
            $uploadedFile = $request->photo;
            $staffFileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/images/staffs', $staffFileName);

        // // Validate the uploaded file
            //   $request->validate([
            //     'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            // ]); 
            // // Store the uploaded file
            // $uploadedFile = $request->file('file');
            // $customerFileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            // $uploadedFile->storeAs('public/images/customers', $customerFileName);

        $data = session('data');

        
        // $staffImage = $this->uploadStaffImage($request);
       
     
       $userFinancials = Financials::create([
            'basicSalary' => $request->basicSalary,
            'bankAccount' => $request->bankAccount,
            'bankAccountHolderName' => $request->bankAccountHolderName,
            'bankName' => $request->bankName,

        ]);

        $financial = Financials::create([
            'basicSalary' => $request->basicSalary,
            'bankAccount' => $request->bankAccount,
            'bankAccountHolderName' => $request->bankAccountHolderName,
            'bankName' => $request->bankName,
        ]);

        $financial_id = $financial->id; 

        $currentYear = date('Y');
        $lastStaffId = DB::table('users')->latest('id')->value('staff_id');
        $lastStaffNumber = intval(substr($lastStaffId, -4)); // Extract the last 4 digits as a number
    
        // Increment the staff number
        $newStaffNumber = $lastStaffNumber + 1;
    
        // Generate the new staff ID
        $newStaffId = 'M/' . $currentYear . '/' . str_pad($newStaffNumber, 4, '0', STR_PAD_LEFT);

        $user = User::create(
         [
            'staff_id' => $newStaffId,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'street' => $request->street,
            'district' => $request->district,
            'region' => $request->region,
            'gender' => $request->gender,
            'maritalStatus' => $request->maritalStatus,
            'email' => $request->email,
            'age' => $request->age,
            'photo' => $staffFileName,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'branch_id' => $request->branch_id,
            'financials_id' => $financial_id,
        ]);

        
        event(new Registered($user));
        // $data = $request->dataImage;
        // Auth::login($user);

        return response(['user created successfully', "img" => $staffFileName]);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $users = User::find($user->id);

        return new StaffResource($users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user_find = User::find($user->id);

        return response()->json(['edit-user' => $user_find]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if($request->hasFile('image')){
            $img = $request->file('image');
            $name = time().'-'. $img->getClientOriginalName();
            $destination = public_path('Images/User');
            $img->move($destination, $name);
        }
        $data = $user->update($request->all());

        return response($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user){

    }
  
}
