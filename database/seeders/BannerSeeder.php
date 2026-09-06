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
                'title' => 'La saison commence ici',
                'subtitle' => 'Tondeuses autoportées, broyeurs, tronçonneuses : le matériel qui tient un terrain toute l\'année.',
                'image' => 'banners/banner-home.jpg',
                'link_url' => '/boutique',
                'position' => 'home_hero',
                'sort_order' => 0,
            ],
            [
                'title' => 'Nouveautés',
                'subtitle' => 'Robots de tonte sans fil périphérique, autoportées à batterie et outils portés.',
                'image' => 'banners/banner-nouveautes-home.jpg',
                'link_url' => '/boutique?is_new=1',
                'position' => 'home_secondary',
                'sort_order' => 0,
            ],
            [
                'title' => 'Livraison offerte dès 500€',
                'subtitle' => 'Sur palette, dans toute la France métropolitaine.',
                'image' => 'banners/banner-livraison.jpg',
                'link_url' => '/livraison',
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
    }
}
