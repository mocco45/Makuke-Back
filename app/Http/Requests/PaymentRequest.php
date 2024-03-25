<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
        
            'amount' => ['required','numeric', 'min_digits:3'],
            'type' => ['required','numeric'],
            'method' => ['required','numeric'],
            // 'amount' => ['numeric', 'min_digits:5'],
        ];

        // 1-5, 5
        // 6-10, 10
        // 11-15, 15
        // 16-20, 20
        // 21-25, 25
        // 26-30, 30
        // 31->above 50
    }
}
