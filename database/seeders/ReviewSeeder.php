<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * A small pool of hand-written French reviews, rotated across products.
     * Not customer-submitted (no submission form exists, per the fidelity
     * decision) — this is admin-curated social proof, seeded directly.
     */
    private const REVIEWS = [
        ['author' => 'Camille D.', 'country' => 'FR', 'rating' => 5, 'comment' => "Machine bien emballée, livrée sur palette au jour annoncé. Montage rapide, elle a démarré au premier essai et le rendu est conforme à la fiche."],
        ['author' => 'Julien M.', 'country' => 'BE', 'rating' => 4, 'comment' => "Bon rapport qualité-prix pour un usage régulier. Un petit bémol sur le délai de livraison, un peu plus long qu'annoncé, mais rien de rédhibitoire."],
        ['author' => 'Sophie L.', 'country' => 'FR', 'rating' => 5, 'comment' => 'Exactement ce qu\'il me fallait pour mon terrain. J\'ai appelé avant de commander pour vérifier la compatibilité, le conseil a été précis et honnête.'],
        ['author' => 'Antoine R.', 'country' => 'CH', 'rating' => 4, 'comment' => 'Matériel solide, conforme à la description. Je recommande, même si le prix reste un investissement à ce niveau de gamme.'],
        ['author' => 'Marie-Claire P.', 'country' => 'FR', 'rating' => 5, 'comment' => 'Deuxième commande chez Sillon & Bûche et toujours aussi satisfaite. La finition se sent tout de suite par rapport à ce qu\'on trouve en grande surface.'],
        ['author' => 'Thomas B.', 'country' => 'LU', 'rating' => 4, 'comment' => "Très satisfait de mon achat, la machine encaisse bien. La prise en main a demandé une matinée, mais le manuel est clair et le résultat en vaut la peine."],
    ];

    public function run(): void
    {
        // Re-seeding would otherwise stack a fresh batch of reviews on top of the previous one
        // every run, and the ratings shown on a product would drift upward for no reason.
        Review::query()->delete();

        // Written per product but inserted in batches: the catalogue runs to several thousand
        // items, so a save() per review turns a few seconds of seeding into several minutes.
        $rows = [];
        $now = now();

        Product::query()->select('id')->chunkById(500, function ($products) use (&$rows, $now) {
            foreach ($products as $product) {
                foreach (collect(self::REVIEWS)->shuffle()->take(random_int(2, 4)) as $review) {
                    $rows[] = [
                        'product_id' => $product->id,
                        'author_name' => $review['author'],
                        'country' => $review['country'],
                        'rating' => $review['rating'],
                        'comment' => $review['comment'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            foreach (array_chunk($rows, 1000) as $batch) {
                DB::table('reviews')->insert($batch);
            }
            $rows = [];
        });
    }
}
