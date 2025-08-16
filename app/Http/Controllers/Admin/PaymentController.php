<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\AdminPaymentStoreRequest;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function store(AdminPaymentStoreRequest $request): RedirectResponse
    {
        $data = array_merge(
            $request->validated(),
            [
                'received_at' => now(),
                'received_by' => $request->user()->id,
            ]
        );

        $user = User::findOrFail($request->input('user_id'));

        $user->payments()->create($data);

        return redirect()->back()
            ->with('success', "Payment saved.");
    }

    public function update(AdminPaymentStoreRequest $request, Payment $payment): RedirectResponse
    {
        $data = array_merge(
            $request->validated(),
            [
                'received_at' => now(),
                'received_by' => $request->user()->id,
            ]
        );

        if ($request->has('received') && $request->input('received') == false) {
            $data['received_at'] = null;
            $data['received_by'] = null;
        }

        $payment->update($data);

        return redirect()->back()
            ->with('success', "Payment saved.");
    }
}
