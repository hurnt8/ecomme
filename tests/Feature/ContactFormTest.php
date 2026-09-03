<?php

use App\Mail\ContactMessage;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

it('sends the contact message to the configured contact address', function () {
    Mail::fake();
    Setting::current()->update(['contact_email' => 'shop@example.com']);

    $this->post(route('contact.store'), [
        'name' => 'Camille Dubois',
        'email' => 'camille@example.com',
        'subject' => 'Question sur une commande',
        'message' => 'Bonjour, ma commande est-elle expédiée ?',
    ])->assertRedirect(route('contact.index'));

    Mail::assertQueued(ContactMessage::class, fn ($mail) => $mail->hasTo('shop@example.com')
        && $mail->senderEmail === 'camille@example.com');
});

it('rejects an empty contact submission with real French messages, not raw translation keys', function () {
    $response = $this->from(route('contact.index'))->post(route('contact.store'), []);

    $response->assertRedirect(route('contact.index'))->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

    $errors = session('errors')->getBag('default');

    expect($errors->first('name'))->toBe('Le champ nom est obligatoire.')
        ->and($errors->first('email'))->toBe('Le champ adresse e-mail est obligatoire.')
        ->and($errors->first('subject'))->toBe('Le champ sujet est obligatoire.')
        ->and($errors->first('message'))->toBe('Le champ message est obligatoire.');
});
