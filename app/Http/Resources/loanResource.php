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
            'category' => $this->category->name,
            'loan_amount' => $this->amount,
            'status' => $this->status,
            'interest_rate' => $this->interest_rate,
            'loan_duration' => $this->repayment_time,
            'created_at' => $this->created_at,
            'customer_name' => $this->customer->firstName.' '. $this->customer->lastName,

            'customer' => $this->customer,
            'customer_property' => $this->customer_guarantee,
            'referee' => $this->referee,
            'referee_guarantee' => $this->referee->map(function ($referee_guarantee) {
                return [
                    'name' => $referee_guarantee->property_name,
                    'value' => $referee_guarantee->value,
                    'address' => $referee_guarantee->property_address,
                    'photo' => $referee_guarantee->photo,
                ];
            }), 'public/images/staffs'

        ];
    }
}