<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'otherName' => 'required|string|max:100',
            'email' => 'required|string|unique:user',
            'gender' => 'required|string|max:1',
            'marital_status' => 'required|string|max:100',
            'phone' => 'required|numeric|max:12|min:10',
            'occupation' => 'required|string|max:100',
            'region' => 'required|string',
            'district' => 'required|string',
            'street' => 'required|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
        ];
    }
}
