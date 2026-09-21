<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            // The home hero slides and the two promo tiles reproduce guerrinibois.fr: its artwork
            // (recompressed from PNG to JPEG) and its slide copy.
            [
                'title' => 'Chauffez votre maison naturellement',
                'subtitle' => 'Qualité • Confort • Énergie durable',
                'image' => 'banners/hero-bois-chauffage.jpg',
                'link_url' => '/boutique?category=bois-chauffage',
                'position' => 'home_hero',
                'sort_order' => 0,
            ],
            [
                'title' => 'L\'expert du bois et du chauffage',
                'subtitle' => 'Chaleur, confort & authenticité',
                'image' => 'banners/hero-expert-bois.jpg',
                'link_url' => '/boutique?category=bois-chauffage',
                'position' => 'home_hero',
                'sort_order' => 1,
            ],
            [
                'title' => 'Abris de jardin en bois',
                'subtitle' => 'Jardin & Extérieur',
                // Photo on the left, solid black panel on the right, where the home page sets the copy.
                'image' => 'banners/promo-abri-jardin.jpg',
                'link_url' => '/boutique?category=jardin-exterieur',
                'position' => 'home_secondary',
                'sort_order' => 0,
            ],
            [
                'title' => 'Aménagez votre extérieur',
                'subtitle' => 'Structures en bois',
                // Red panel on the left. The Guerrini tile linked to the carport pictured, which this
                // shop does not sell, so it opens the garden range instead.
                'image' => 'banners/promo-carport.jpg',
                'link_url' => '/boutique?category=jardin-exterieur',
                'position' => 'home_secondary',
                'sort_order' => 1,
            ],
            [
                'title' => 'Les nouveautés du mois',
                'subtitle' => 'Les dernières machines entrées en stock.',
                // Recut from the supplier's own product photography — see the banners.php note in
                // assets/banners: the square studio shots are composited onto a canvas flood-filled
                // with their own ground colour rather than cropped, so no machine loses its top.
                'image' => 'banners/banner-nouveautes.jpg',
                'link_url' => null,
                'position' => 'shop_new',
                'sort_order' => 0,
            ],
            [
                'title' => 'Promotions',
                'subtitle' => "Jusqu'à 20% sur une sélection de machines.",
                // The Ceccato Trincione 400, which is itself on promotion.
                'image' => 'banners/banner-promotions.jpg',
                'link_url' => null,
                'position' => 'shop_sale',
                'sort_order' => 0,
            ],
        ];

        foreach ($banners as $banner) {
            $file = basename($banner['image']);

            if (! Storage::disk('public')->exists($banner['image'])) {
                Storage::disk('public')->put(
                    $banner['image'],
                    file_get_contents(__DIR__.'/assets/banners/'.$file)
                );
            }

            Banner::query()->updateOrCreate(
                ['position' => $banner['position'], 'title' => $banner['title']],
                $banner + ['is_active' => true]
            );
        }

        // Banners from the furniture catalogue, whose titles no longer appear above and which
        // would otherwise keep showing a sideboard on the home page.
        Banner::query()->whereIn('title', [
            'La collection automne',
            'Livraison offerte dès 150€',
        ])->delete();

        // The home banners the guerrinibois.fr slides and tiles above replaced.
        Banner::query()->whereIn('position', ['home_hero', 'home_secondary'])->whereIn('title', [
            'La saison commence ici',
            'Nouveautés',
            'Livraison offerte dès 500€',
        ])->delete();
    }
}
