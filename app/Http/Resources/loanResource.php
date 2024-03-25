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
            'loan_duration' => $this->day->duration,
            'interest_rate' => $this->interest->percent,
            'fee' => $this->formfee->percent,
            'loan_amount' => $this->amount,
            'original_amount' => $this->original,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'customer_name' => $this->customer->firstName.' '. $this->customer->lastName,
            'loan_remain' => $this->loan_remain,
            'customer' => $this->customer,
            'customer_property' => $this->customer_guarantee,
            'referee' => $this->referee,
            'referee_guarantee' => $this->referee->map(function ($referee_guarantee) {
                return [
                    'name' => $referee_guarantee->referee_guarantee[0]->property_name,
                    'value' => $referee_guarantee->referee_guarantee[0]->value,
                    'region' => $referee_guarantee->referee_guarantee[0]->region,
                    'district' => $referee_guarantee->referee_guarantee[0]->district,
                    'street' => $referee_guarantee->referee_guarantee[0]->street,
                    'photo' => $referee_guarantee->referee_guarantee[0]->photo_ref_guarantee,
                ];
            }),
            'payment_method' => $this->branch->payment_method,
            'payment_type' => $this->branch->payment_type,
        ];
    }
}