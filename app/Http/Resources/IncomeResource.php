<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            $this->account_name->map(function ($account){
                return [
                    'code' => $account->code
                ];
            }),
            'incomeAmount' => $this->incomeAmount,
            'paymentMethod' => $this->payment_method->payment_method,
            'paymentType' => $this->payment_type->payment_type,
            'incomeDescription' => $this->incomeDescription
        ];
    }
}
