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
            'site_name' => 'Sillon & Bûche',
            // Explicitly cleared, not merely left unset: the row already carried an uploaded
            // "Atelier Maison" mark (a wordmark under a roofline), and updateOrCreate would have
            // preserved it — the old brand would have kept sitting in the header of every page.
            // The header falls back to the site name as text until a new mark is uploaded
            // through /admin/reglages.
            'logo' => null,
            'tagline' => 'Motoculture et bois de chauffage pour ceux qui entretiennent leur terrain',
            'description' => 'Sillon & Bûche vend le matériel qui tient un terrain toute l\'année : tronçonneuses et élagueuses, tracteurs tondeuses, broyeurs et outils portés, débroussailleuses et motoculteurs — puis le bois et les granulés pour l\'hiver. Machines choisies pour être réparables, conseil avant achat, livraison sur palette.',
            'contact_email' => 'contact@sillon-buche.test',
            'contact_phone' => '+33 2 38 30 41 12',
            'contact_address' => 'Zone artisanale des Ormes, 45300 Pithiviers',
            'whatsapp_number' => '+33612345678',
            'social_facebook' => 'https://facebook.com/sillonetbuche',
            'social_instagram' => 'https://instagram.com/sillonetbuche',
            'social_twitter' => null,
            'tax_rate' => 0.2,
            // Machines travel on a pallet, so delivery is a real cost here rather than a rounding
            // error on a cushion: the threshold sits above the accessory range, not below it.
            'free_shipping_threshold' => 500,
            'international_shipping_fee' => 90,
            'currency' => 'EUR',
            'sale_ends_at' => now()->addDays(7),
            'announcement_text' => 'Livraison sur palette offerte dès 500€ d\'achat en France métropolitaine',
            'bank_account_holder' => 'Sillon & Bûche SAS',
            'bank_name' => 'Crédit Agricole Centre-Loire',
            'bank_iban' => 'FR76 3000 4000 0100 0012 3456 789',
            'bank_bic' => 'AGRIFRPP845',
            'notify_new_orders' => true,
            'notification_email' => 'commandes@sillon-buche.test',
        ]);

        // SettingsService caches the row for an hour and is only invalidated by its own update().
        // Writing straight to the model here would otherwise leave the shop serving the previous
        // identity — name, logo, shipping threshold — for up to an hour after a re-seed.
        app(SettingsService::class)->forget();
    }
}
