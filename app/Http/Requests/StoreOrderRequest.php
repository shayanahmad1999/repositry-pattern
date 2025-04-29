<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client' => 'required|string|max:255',
            'details' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'client.required' => 'Client name is required.',
            'details.required' => 'Order details cannot be empty.',
        ];
    }
}
