<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * A small pool of hand-written French reviews, rotated across products.
     * Not customer-submitted (no submission form exists, per the fidelity
     * decision) — this is admin-curated social proof, seeded directly.
     */
    private const REVIEWS = [
        ['author' => 'Camille D.', 'country' => 'FR', 'rating' => 5, 'comment' => "Très belle finition, le bois est encore plus beau en vrai qu'en photo. Livraison soignée, emballage impeccable."],
        ['author' => 'Julien M.', 'country' => 'BE', 'rating' => 4, 'comment' => "Bon rapport qualité-prix, le montage était simple. Un petit bémol sur le délai de livraison, un peu plus long qu'annoncé."],
        ['author' => 'Sophie L.', 'country' => 'FR', 'rating' => 5, 'comment' => "Exactement ce que je cherchais pour compléter mon salon. Le service client a été très réactif à mes questions avant achat."],
        ['author' => 'Antoine R.', 'country' => 'CH', 'rating' => 4, 'comment' => "Belle pièce, conforme à la description. Je recommande, même si le prix reste un investissement."],
        ['author' => 'Marie-Claire P.', 'country' => 'FR', 'rating' => 5, 'comment' => "Coup de cœur ! La qualité des matériaux se sent tout de suite. Deuxième commande chez Atelier Maison et toujours aussi satisfaite."],
        ['author' => 'Thomas B.', 'country' => 'LU', 'rating' => 4, 'comment' => "Très satisfait de mon achat, le produit est solide et bien fini. L'assemblage a pris un peu de temps mais le résultat en vaut la peine."],
    ];

    public function run(): void
    {
        Product::query()->each(function (Product $product) {
            $reviews = collect(self::REVIEWS)->shuffle()->take(random_int(2, 4));

            foreach ($reviews as $review) {
                $product->reviews()->create([
                    'author_name' => $review['author'],
                    'country' => $review['country'],
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                ]);
            }
        });
    }
}
