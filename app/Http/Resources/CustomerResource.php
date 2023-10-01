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
            'photo' => asset('storage/app/public/images/customers/'.$this->photo),
            'photo_ref' => asset('storage/app/public/images/referee/'.$this->photo),
            'photo_ref_guarantee' => asset('storage/app/public/images/referee-guarantees/'.$this->photo),
            'photo_customer_guarantee' => asset('storage/app/public/images/customer-guarantees/'.$this->photo),
        ];
    }
}
