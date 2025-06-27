<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\PaymentStoreRequest;
use App\Models\Payment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('payment/Index')
            ->with('attendees', $request->user()->attendees)
            ->with('payments', $request->user()->payments);
    }

    public function store(PaymentStoreRequest $request): RedirectResponse
    {
        $request->user()->payments()->save(new Payment($request->validated()));

        return redirect()->back()
            ->with('success', "Payment saved.  To avoid getting a payment reminder, please send payment soon!");
    }

    public function update(PaymentStoreRequest $request, Payment $payment): RedirectResponse
    {
        $payment->update($request->validated());

        return redirect()->back()
            ->with('success', "Payment saved.  To avoid getting a payment reminder, please send payment soon!");
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->back()
            ->with('success', "Payment deleted");
    }

}
