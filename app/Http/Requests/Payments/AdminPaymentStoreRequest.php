<?php

namespace App\Http\Requests\Payments;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminPaymentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'user_notes' => [''],
            'admin_notes' => [''],
            'set_received' => ['optional', 'boolean'],
        ];
    }

    public function messages() : array
    {
        return [];
    }
}
