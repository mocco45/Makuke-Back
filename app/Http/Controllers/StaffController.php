<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::all();

        return response()->json($staffs);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'age' => ['required', 'integer'],
            'street' => ['required', 'string'],
            'district' => ['required', 'string'],
            'region' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'maritalStatus' => ['required', 'string'],
            'branch' => ['required', 'string'],
            'position' => ['required', 'string'],
            'basicSalary' => ['required', 'integer'],
            'bankAccountHolder' => ['required', 'string'],
            'bankAccountNumber' => ['required', 'integer'],
            'bankName' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create(
            $request->all() + [
                'password' => Hash::make($request->password),
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
