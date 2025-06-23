<?php

namespace App\Http\Requests\Verification;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificationStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'xid' => ['exists:users'],
            'verify' => ['filled', 'boolean', 'accepted'],
        ];
    }
}
