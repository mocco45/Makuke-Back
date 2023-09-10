<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->firstName,
            'fullName' => $this->firstName .' '. $this->lastName,
            'phone' => $this->phone,
            'street' => $this->street,
            'district' => $this->district,
            'region' => $this->region,
            'gender' => $this->gender,
            'maritalStatus' => $this->maritalStatus,
            // 'financials' => $this->financials->map(function($financials){
            //     return [ 
            //         'basicSalary' => $financials->basicSalary,
            //         'bankAccount' => $financials->bankAccount,
            //         'bankName' => $financials->bankName,
            //         'bankAccountHolderName' => $financials->bankAccountHolderName,
            //     ];}),
            'financials' => $this->financials->map(function ($financials) {
                return [
                    'basicSalary' => $financials->basicSalary,
                    'bankAccount' => $financials->bankAccount,
                    'bankName' => $financials->bankName,
                    'bankAccountHolderName' => $financials->bankAccountHolderName,
                ];
            })->first(), // Use first() to return the first financials object
            'role' => $this->role->name,
            'branch' => $this->branch->branch_name,
            'email' => $this->email,
            'photo' => $this->photo,
            'created_at' => $this->created_at,
            
        ];
    }
}
