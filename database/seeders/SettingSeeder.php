<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'site_name' => 'Atelier Maison',
            'tagline' => 'Mobilier et décoration pour une maison qui vous ressemble',
            'description' => 'Atelier Maison sélectionne pour vous meubles et objets de décoration au design intemporel, fabriqués avec des matériaux durables. Livraison soignée, retours gratuits sous 30 jours.',
            'contact_email' => 'contact@atelier-maison.test',
            'contact_phone' => '+33 1 84 60 12 34',
            'contact_address' => '12 rue du Faubourg Saint-Antoine, 75011 Paris',
            'whatsapp_number' => '+33612345678',
            'social_facebook' => 'https://facebook.com/ateliermaison',
            'social_instagram' => 'https://instagram.com/ateliermaison',
            'social_twitter' => null,
            'tax_rate' => 0.2,
            'free_shipping_threshold' => 150,
            'international_shipping_fee' => 25,
            'currency' => 'EUR',
            'sale_ends_at' => null,
            'announcement_text' => 'Livraison offerte dès 150€ d\'achat en France métropolitaine',
            'bank_account_holder' => 'Atelier Maison SAS',
            'bank_name' => 'Banque Populaire',
            'bank_iban' => 'FR76 3000 4000 0100 0012 3456 789',
            'bank_bic' => 'BNPAFRPPXXX',
            'notify_new_orders' => true,
            'notification_email' => 'commandes@atelier-maison.test',
        ]);
    }
}
