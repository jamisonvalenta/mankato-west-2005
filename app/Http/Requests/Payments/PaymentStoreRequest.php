<?php

namespace App\Http\Requests\Payments;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentStoreRequest extends FormRequest
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
            'user_notes' => ['required', 'string'],
        ];
    }

    public function messages() : array
    {
        return [
            'user_notes.required' => "To assist us in matching your payment, please specify the account you'll send from",
        ];
    }
}
