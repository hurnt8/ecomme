@extends('layouts.admin')

@section('title', 'Réglages')

@section('content')
    @php
        // Which fields live under which tab. Drives both the error badges and the tab that opens
        // first when validation fails — a rejected field on a closed tab would otherwise be
        // invisible, and the admin would see "des erreurs" with nothing to correct on screen.
        $tabs = [
            'boutique' => [
                'label' => 'Boutique',
                'fields' => ['site_name', 'tagline', 'description', 'logo', 'announcement_text', 'sale_ends_at'],
            ],
            'contact' => [
                'label' => 'Contact & réseaux',
                'fields' => ['contact_email', 'contact_phone', 'contact_address', 'whatsapp_number', 'social_facebook', 'social_instagram', 'social_twitter'],
            ],
            'legal' => [
                'label' => 'Identité légale',
                'fields' => ['legal_name', 'legal_form', 'siren', 'siret', 'vat_number', 'naf_code', 'naf_label', 'registered_address', 'publication_director', 'host_details'],
            ],
            'commerce' => [
                'label' => 'Taxes & livraison',
                'fields' => ['currency', 'tax_rate', 'free_shipping_threshold', 'international_shipping_fee'],
            ],
            'banque' => [
                'label' => 'Coordonnées bancaires',
                'fields' => ['bank_account_holder', 'bank_name', 'bank_iban', 'bank_bic'],
            ],
            'notifications' => [
                'label' => 'Notifications',
                'fields' => ['notify_new_orders', 'notification_email'],
            ],
        ];

        $errorCounts = collect($tabs)->map(fn ($tab) => collect($tab['fields'])->filter(fn ($f) => $errors->has($f))->count());
        $openTab = $errorCounts->filter()->keys()->first() ?? array_key_first($tabs);
    @endphp

    {{-- Every panel stays in the DOM (x-show, never x-if): the five sections post as one form,
         so a template-removed field would submit nothing and blank that setting on save. --}}
    <div x-data="{ tab: @js($openTab) }" class="max-w-5xl">
        <form method="POST" action="{{ route('admin.reglages.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="flex flex-col gap-6 md:flex-row md:items-start">
                <nav class="shrink-0 md:sticky md:top-6 md:w-56" aria-label="Sections des réglages">
                    <ul class="flex flex-wrap gap-1 md:block md:space-y-1">
                        @foreach ($tabs as $key => $tab)
                            <li>
                                <button type="button" x-on:click="tab = @js($key)"
                                        x-bind:class="tab === @js($key)
                                            ? 'border-brand-400 bg-white font-medium text-neutral-900'
                                            : 'border-transparent text-neutral-600 hover:bg-neutral-100 hover:text-neutral-900'"
                                        class="flex w-full items-center justify-between gap-2 rounded-md border-l-2 px-3 py-2 text-left text-sm transition-colors">
                                    <span>{{ $tab['label'] }}</span>
                                    @if ($errorCounts[$key] > 0)
                                        <span class="rounded-full bg-clay-100 px-1.5 py-0.5 text-[11px] font-semibold text-clay-700">{{ $errorCounts[$key] }}</span>
                                    @endif
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <div class="min-w-0 flex-1">
                    {{-- The inline display honours $openTab before Alpine boots, so the right panel
                         paints immediately and the page stays usable if Alpine never loads. --}}
                    <section x-show="tab === 'boutique'" @style(['display:none' => $openTab !== 'boutique'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Boutique</h2>
                        <div class="space-y-4">
                            <x-admin.field label="Nom de la boutique" name="site_name" :value="$settings->site_name" required />
                            <x-admin.field label="Slogan" name="tagline" :value="$settings->tagline" />
                            <x-admin.field label="Description" name="description" type="textarea" :value="$settings->description" />
                            <div>
                                <label for="logo" class="mb-1 block text-sm font-medium text-neutral-700">Logo</label>
                                @if ($settings->logo_url)
                                    <img src="{{ $settings->logo_url }}" alt="Logo actuel" class="mb-2 h-16 w-auto rounded border border-neutral-200 bg-white p-1">
                                @endif
                                <input type="file" name="logo" id="logo" accept="image/*">
                                <p class="mt-1 text-xs text-neutral-500">
                                    Affiché dans l'en-tête de la boutique. Les images de plus de 512&nbsp;px sont réduites automatiquement.
                                </p>
                            </div>
                            <x-admin.field label="Bandeau d'annonce" name="announcement_text" :value="$settings->announcement_text" />
                            <div>
                                <x-admin.field label="Fin de la promotion en cours (optionnel)" name="sale_ends_at" type="datetime-local"
                                               :value="$settings->sale_ends_at?->format('Y-m-d\TH:i')" />
                                <p class="mt-1 text-xs text-neutral-500">
                                    Affiche un compte à rebours sur la bannière « Boutique — promotions ». Laissez vide pour le masquer.
                                </p>
                            </div>
                        </div>
                    </section>

                    <section x-show="tab === 'contact'" @style(['display:none' => $openTab !== 'contact'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Contact &amp; réseaux sociaux</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.field label="E-mail de contact" name="contact_email" type="email" :value="$settings->contact_email" />
                            <x-admin.field label="Téléphone" name="contact_phone" :value="$settings->contact_phone" />
                            <x-admin.field label="Adresse" name="contact_address" :value="$settings->contact_address" />
                            <x-admin.field label="Numéro WhatsApp" name="whatsapp_number" :value="$settings->whatsapp_number" placeholder="+33612345678" />
                            <x-admin.field label="Facebook (URL)" name="social_facebook" :value="$settings->social_facebook" />
                            <x-admin.field label="Instagram (URL)" name="social_instagram" :value="$settings->social_instagram" />
                            <x-admin.field label="Twitter / X (URL)" name="social_twitter" :value="$settings->social_twitter" />
                        </div>
                    </section>

                    <section x-show="tab === 'legal'" @style(['display:none' => $openTab !== 'legal'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Identité légale</h2>
                        <p class="mb-4 text-xs text-neutral-500">
                            Reprises sur les mentions légales, les CGV, les factures et les reçus. Un champ laissé vide n'est pas affiché.
                        </p>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.field label="Raison sociale (nom de l'exploitant)" name="legal_name" :value="$settings->legal_name" placeholder="Frédéric SOUVILLE" />
                            <x-admin.field label="Forme juridique" name="legal_form" :value="$settings->legal_form" placeholder="Entrepreneur individuel" />
                            <x-admin.field label="SIREN" name="siren" :value="$settings->siren" placeholder="981 826 803" />
                            <x-admin.field label="SIRET du siège social" name="siret" :value="$settings->siret" placeholder="981 826 803 00018" />
                            <x-admin.field label="N° TVA intracommunautaire" name="vat_number" :value="$settings->vat_number" placeholder="Laisser vide si non assujetti" />
                            <x-admin.field label="Code NAF/APE" name="naf_code" :value="$settings->naf_code" placeholder="46.71Z" />
                            <x-admin.field label="Libellé NAF/APE" name="naf_label" :value="$settings->naf_label" />
                            <x-admin.field label="Adresse du siège social" name="registered_address" :value="$settings->registered_address" placeholder="Hourquette, 32300 Estipouy" />
                            <x-admin.field label="Directeur de la publication" name="publication_director" :value="$settings->publication_director" />
                            <x-admin.field label="Hébergeur (nom et adresse)" name="host_details" :value="$settings->host_details" />
                        </div>
                    </section>

                    <section x-show="tab === 'commerce'" @style(['display:none' => $openTab !== 'commerce'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Taxes &amp; livraison</h2>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.field label="Devise (ISO 3, ex. EUR)" name="currency" :value="$settings->currency" required />
                            <x-admin.field label="Taux de taxe (ex. 0.20 pour 20 %)" name="tax_rate" type="number" step="0.0001" min="0" max="1" :value="$settings->tax_rate" required />
                            <x-admin.field label="Seuil de livraison offerte ({{ $settings->currency_symbol }})" name="free_shipping_threshold" type="number" step="0.01" min="0" :value="$settings->free_shipping_threshold" required />
                            <x-admin.field label="Frais hors zone euro ({{ $settings->currency_symbol }})" name="international_shipping_fee" type="number" step="0.01" min="0" :value="$settings->international_shipping_fee" required />
                        </div>
                    </section>

                    <section x-show="tab === 'banque'" @style(['display:none' => $openTab !== 'banque'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Coordonnées bancaires (virement)</h2>
                        <p class="mb-4 text-xs text-neutral-500">
                            Reprises sur la confirmation de commande et sur la facture : c'est avec ces informations que le client règle.
                        </p>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.field label="Titulaire du compte" name="bank_account_holder" :value="$settings->bank_account_holder" />
                            <x-admin.field label="Banque" name="bank_name" :value="$settings->bank_name" />
                            <x-admin.field label="IBAN" name="bank_iban" :value="$settings->bank_iban" />
                            <x-admin.field label="BIC" name="bank_bic" :value="$settings->bank_bic" />
                        </div>
                    </section>

                    <section x-show="tab === 'notifications'" @style(['display:none' => $openTab !== 'notifications'])
                             class="rounded-lg border border-neutral-200 bg-white p-5">
                        <h2 class="mb-4 text-sm font-semibold">Notifications</h2>
                        <div class="space-y-4">
                            <x-admin.checkbox label="M'avertir des nouvelles commandes par e-mail" name="notify_new_orders" :checked="$settings->notify_new_orders" />
                            <x-admin.field label="E-mail de notification (sinon, e-mail de contact)" name="notification_email" type="email" :value="$settings->notification_email" />
                        </div>
                    </section>

                    {{-- Sticky so Enregistrer is reachable from any tab without scrolling to the
                         bottom of the longest one. --}}
                    <div class="sticky bottom-0 mt-4 flex items-center gap-3 border-t border-neutral-200 bg-neutral-50/95 py-3 backdrop-blur">
                        <button type="submit" class="rounded-md bg-brand-400 px-5 py-2 text-sm font-medium text-neutral-900 transition-colors hover:bg-brand-500">
                            Enregistrer les réglages
                        </button>
                        <span class="text-xs text-neutral-500">Les cinq sections sont enregistrées ensemble.</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
