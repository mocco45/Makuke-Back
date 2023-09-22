<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class loanResource extends JsonResource
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
            // 'customerId' => $this->customer->id,
            // 'customer' => $this->customer->firstName.' '. $this->customer->lastName,
            // 'gender' => $this->customer->gender,
            // 'email' => $this->customer->email,
            // 'phone' => $this->customer->phone,
            // 'region' => $this->customer->region,
            // 'district' => $this->customer->district,
            // 'street' => $this->customer->street,

            'category' => $this->category->name,
            'loan_amount'=> $this->amount,
            'status'=> $this->status,
            'interest_rate'=> $this->interest_rate,
            'loan_duration'=> $this->repayment_time,
            'created_at'=> $this->created_at,
            'customer' => $this->customer,
            'customer_property' => $this->customer_guarantee,
            'referee' => $this->referee,
            
        ];
    }
}
