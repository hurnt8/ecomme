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
            [
                'title' => 'La collection automne',
                'subtitle' => 'Des pièces en bois massif et matières naturelles pour réchauffer votre intérieur.',
                'image' => 'banners/banner-home.jpg',
                'link_url' => '/boutique',
                'position' => 'home_hero',
                'sort_order' => 0,
            ],
            [
                'title' => 'Nouveautés',
                'subtitle' => 'De nouvelles pièces chaque mois, sélectionnées par notre atelier.',
                'image' => 'banners/banner-nouveautes-home.jpg',
                'link_url' => '/boutique?is_new=1',
                'position' => 'home_secondary',
                'sort_order' => 0,
            ],
            [
                'title' => 'Livraison offerte dès 150€',
                'subtitle' => 'Sur toute la France métropolitaine.',
                'image' => 'banners/banner-livraison.jpg',
                'link_url' => '/livraison',
                'position' => 'home_secondary',
                'sort_order' => 1,
            ],
            [
                'title' => 'Les nouveautés du mois',
                'subtitle' => 'Découvrez les dernières pièces arrivées en atelier.',
                // Recut from the supplier's own photography. The template's img_bg_4 and
                // img_bg_5 were stock shots of things the shop does not sell — a generic chair,
                // and a man crouching beside a boat above the word "Promotions".
                'image' => 'banners/banner-nouveautes.jpg',
                'link_url' => null,
                'position' => 'shop_new',
                'sort_order' => 0,
            ],
            [
                'title' => 'Promotions',
                'subtitle' => "Jusqu'à 20% sur une sélection de pièces.",
                // The table basse BOATWOOD, which is itself on promotion.
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
    }
}
