<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\ContactRequest;
use App\Mail\ContactMessage;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('shop.contact');
    }

    public function store(ContactRequest $request, SettingsService $settings): RedirectResponse
    {
        $data = $request->validated();
        $current = $settings->current();
        $recipient = $current->contact_email ?: $current->notification_email;

        if ($recipient) {
            try {
                Mail::to($recipient)->send(new ContactMessage(
                    senderName: $data['name'],
                    senderEmail: $data['email'],
                    messageSubject: $data['subject'],
                    body: $data['message'],
                ));
            } catch (\Throwable $e) {
                Log::error('Failed to send contact message', ['error' => $e->getMessage()]);

                return back()->withInput()->with('toast', [
                    'message' => 'Une erreur est survenue, merci de réessayer ou de nous contacter directement par e-mail.',
                    'type' => 'error',
                ]);
            }
        }

        return redirect()->route('contact.index')->with('toast', [
            'message' => 'Votre message a bien été envoyé, nous vous répondrons rapidement.',
            'type' => 'success',
        ]);
    }
}
