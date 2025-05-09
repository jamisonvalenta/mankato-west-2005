<?php

namespace App\Http\Requests\Registration;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'original_name' => ['max:255'],
            'show_attendance' => ['filled', 'boolean'],
            'phone' => ['max:255'],
            'city' => ['max:255'],
            'state' => ['max:255'],
            'country' => ['max:255'],
            'bio' => ['max:2000'],
        ];
    }
}
