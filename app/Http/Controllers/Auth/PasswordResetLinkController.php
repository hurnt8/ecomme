<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        // Always respond the same way whether or not the address exists —
        // confirming/denying an account's existence here would leak which
        // e-mails are registered.
        Password::sendResetLink($request->only('email'));

        return back()->with('toast', [
            'message' => 'Falls zu dieser Adresse ein Konto existiert, wurde soeben ein Link zum Zurücksetzen des Passworts gesendet.',
            'type' => 'success',
        ]);
    }
}
