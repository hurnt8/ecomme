@extends('layouts.admin')

@section('title', 'Réglages')

@section('content')
    <form method="POST" action="{{ route('admin.reglages.update') }}" enctype="multipart/form-data" class="max-w-3xl space-y-8">
        @csrf
        @method('PATCH')

        <section class="bg-white rounded-lg border border-neutral-200 p-5">
            <h2 class="text-sm font-semibold mb-4">Boutique</h2>
            <div class="space-y-4">
                <x-admin.field label="Nom de la boutique" name="site_name" :value="$settings->site_name" required />
                <x-admin.field label="Slogan" name="tagline" :value="$settings->tagline" />
                <x-admin.field label="Description" name="description" type="textarea" :value="$settings->description" />
                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1">Logo</label>
                    <input type="file" name="logo" accept="image/*" class="text-sm">
                    @if ($settings->logo)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings->logo) }}" alt="" class="h-12 mt-2">
                    @endif
                </div>
                <x-admin.field label="Bandeau d'annonce" name="announcement_text" :value="$settings->announcement_text" />
                <x-admin.field label="Fin de la promotion en cours (optionnel)" name="sale_ends_at" type="datetime-local"
                                :value="$settings->sale_ends_at?->format('Y-m-d\TH:i')" />
                <p class="text-xs text-neutral-400 -mt-2">
                    Affiche un compte à rebours sur la bannière « Boutique — promotions ». Laissez vide pour masquer le compte à rebours.
                </p>
            </div>
        </section>

        <section class="bg-white rounded-lg border border-neutral-200 p-5">
            <h2 class="text-sm font-semibold mb-4">Contact &amp; réseaux sociaux</h2>
            <div class="grid grid-cols-2 gap-4">
                <x-admin.field label="E-mail de contact" name="contact_email" type="email" :value="$settings->contact_email" />
                <x-admin.field label="Téléphone" name="contact_phone" :value="$settings->contact_phone" />
                <x-admin.field label="Adresse" name="contact_address" :value="$settings->contact_address" />
                <x-admin.field label="Numéro WhatsApp" name="whatsapp_number" :value="$settings->whatsapp_number" placeholder="+33612345678" />
                <x-admin.field label="Facebook (URL)" name="social_facebook" :value="$settings->social_facebook" />
                <x-admin.field label="Instagram (URL)" name="social_instagram" :value="$settings->social_instagram" />
                <x-admin.field label="Twitter / X (URL)" name="social_twitter" :value="$settings->social_twitter" />
            </div>
        </section>

        <section class="bg-white rounded-lg border border-neutral-200 p-5">
            <h2 class="text-sm font-semibold mb-4">Taxes &amp; livraison</h2>
            <div class="grid grid-cols-2 gap-4">
                <x-admin.field label="Devise (ISO 3, ex. EUR)" name="currency" :value="$settings->currency" required />
                <x-admin.field label="Taux de taxe (ex. 0.20 pour 20%)" name="tax_rate" type="number" step="0.0001" min="0" max="1" :value="$settings->tax_rate" required />
                <x-admin.field label="Seuil de livraison offerte (€)" name="free_shipping_threshold" type="number" step="0.01" min="0" :value="$settings->free_shipping_threshold" required />
                <x-admin.field label="Frais de livraison hors zone euro (€)" name="international_shipping_fee" type="number" step="0.01" min="0" :value="$settings->international_shipping_fee" required />
            </div>
        </section>

        <section class="bg-white rounded-lg border border-neutral-200 p-5">
            <h2 class="text-sm font-semibold mb-4">Coordonnées bancaires (virement)</h2>
            <div class="grid grid-cols-2 gap-4">
                <x-admin.field label="Titulaire du compte" name="bank_account_holder" :value="$settings->bank_account_holder" />
                <x-admin.field label="Banque" name="bank_name" :value="$settings->bank_name" />
                <x-admin.field label="IBAN" name="bank_iban" :value="$settings->bank_iban" />
                <x-admin.field label="BIC" name="bank_bic" :value="$settings->bank_bic" />
            </div>
        </section>

        <section class="bg-white rounded-lg border border-neutral-200 p-5">
            <h2 class="text-sm font-semibold mb-4">Notifications</h2>
            <div class="space-y-4">
                <x-admin.checkbox label="M'avertir des nouvelles commandes par e-mail" name="notify_new_orders" :checked="$settings->notify_new_orders" />
                <x-admin.field label="E-mail de notification (sinon, e-mail de contact)" name="notification_email" type="email" :value="$settings->notification_email" />
            </div>
        </section>

        <button type="submit" class="rounded-md bg-neutral-900 text-white text-sm px-5 py-2 hover:bg-neutral-800">
            Enregistrer les réglages
        </button>
    </form>
@endsection
