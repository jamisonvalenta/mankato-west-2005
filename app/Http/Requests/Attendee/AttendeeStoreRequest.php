<?php

namespace App\Http\Requests\Attendee;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AttendeeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'nametag' => ['max:100'],
            'accommodation_requests' => ['max:3000'],
            'emergency_contact_name' => ['required', 'max:255'],
            'emergency_contact_phone' => ['required', 'max:15'],
            'emergency_contact_relationship' => ['max:100'],
        ];
    }
}
