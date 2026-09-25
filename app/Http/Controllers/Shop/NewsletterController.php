<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\NewsletterSubscribeRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function store(NewsletterSubscribeRequest $request): RedirectResponse
    {
        Subscriber::create(['email' => $request->validated('email')]);

        return back()->with('toast', [
            'message' => 'Danke für Ihre Anmeldung zu unserem Newsletter!',
            'type' => 'success',
        ]);
    }
}
