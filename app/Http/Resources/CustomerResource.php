<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fullname' => $this->firstName.' '.$this->lastName,
            'other_name' => $this->otherName,
            'email' => $this->email,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'phone' => $this->phone,
            'nida' => $this->nida,
            'occupation' => $this->occupation,
            'region' => $this->region,
            'district' => $this->district,
            'street' => $this->street,            
        ];
    }
}
