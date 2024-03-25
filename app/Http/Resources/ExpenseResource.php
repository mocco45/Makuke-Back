<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'expenseDate' => $this->expenseDate,
            'expenseAmount' => $this->expenseAmount,
            'paymentMethod' => $this->payment_method->payment_method,
            'paymentType' => $this->payment_type->payment_type,
            'expenseDescription' => $this->expenseDescription
        ];
    }
}
