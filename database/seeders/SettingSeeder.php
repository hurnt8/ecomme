<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'site_name' => 'Souville Bois de Chauffage',
            // Registered identity, as published at the RNE (SIREN 981 826 803). The trading name
            // above is what customers read; this is what the mentions légales, the CGV and the
            // invoice footer must carry.
            'legal_name' => 'Frédéric SOUVILLE',
            'legal_form' => 'Entrepreneur individuel',
            'siren' => '981 826 803',
            'siret' => '981 826 803 00018',
            // The RNE record reads "Pas de n° TVA valide". Left null rather than invented: the
            // invoice and the mentions légales both omit the line entirely when it is empty.
            'vat_number' => null,
            'naf_code' => '46.71Z',
            'naf_label' => 'Commerce de gros (commerce interentreprises) de combustibles et de produits annexes',
            'registered_address' => 'Hourquette, 32300 Estipouy',
            'publication_director' => 'Frédéric SOUVILLE',
            'host_details' => 'Hostinger International Ltd, 61 Lordou Vironos Street, 6023 Larnaca, Chypre',
            // Explicitly cleared, not merely left unset: the row already carried an uploaded
            // "Atelier Maison" mark (a wordmark under a roofline), and updateOrCreate would have
            // preserved it — the old brand would have kept sitting in the header of every page.
            // The header falls back to the site name as text until a new mark is uploaded
            // through /admin/reglages.
            'logo' => null,
            'tagline' => 'Bois de chauffage et matériel pour entretenir son terrain, toute l\'année',
            'description' => 'Souville Bois de Chauffage vend le bois et les granulés pour passer l\'hiver, et le matériel qui tient un terrain le reste de l\'année : tondeuses et robots, autoportées, tronçonneuses et élagueuses, broyeurs et outils portés, débroussailleuses et motoculteurs, pompes et pulvérisateurs, barbecues et piscines. Machines choisies pour être réparables, conseil avant achat, livraison sur palette.',
            'contact_email' => 'contact@expediva.online',
            // Placeholder: the RNE record carries no published telephone number. Replace from
            // /admin/reglages before launch, or clear it — the footer and the invoice both hide
            // the line when it is empty rather than printing a wrong number.
            'contact_phone' => null,
            'contact_address' => 'Hourquette, 32300 Estipouy',
            // Cleared rather than carried over: the previous values pointed at accounts of the
            // former identity. A footer icon linking to someone else's page is worse than no icon,
            // and every one of these is hidden when empty.
            'whatsapp_number' => null,
            'social_facebook' => null,
            'social_instagram' => null,
            'social_twitter' => null,
            'tax_rate' => 0.2,
            // Machines travel on a pallet, so delivery is a real cost here rather than a rounding
            // error on a cushion: the threshold sits above the accessory range, not below it.
            'free_shipping_threshold' => 500,
            'international_shipping_fee' => 90,
            'currency' => 'EUR',
            'sale_ends_at' => now()->addDays(7),
            'announcement_text' => 'Livraison sur palette offerte dès 500€ d\'achat en France métropolitaine',
            // Deliberately empty. The previous row held an invented IBAN under a company name
            // ("Sillon & Bûche SAS") that does not exist; printing it on an invoice would send
            // customer transfers into the void. The invoice hides the whole bank block when the
            // IBAN is empty, so the real details must be entered from /admin/reglages.
            'bank_account_holder' => null,
            'bank_name' => null,
            'bank_iban' => null,
            'bank_bic' => null,
            'notify_new_orders' => true,
            'notification_email' => 'contact@expediva.online',
        ]);

        // SettingsService caches the row for an hour and is only invalidated by its own update().
        // Writing straight to the model here would otherwise leave the shop serving the previous
        // identity — name, logo, shipping threshold — for up to an hour after a re-seed.
        app(SettingsService::class)->forget();
    }
}
