<?php

namespace App\Services;

use App\Models\Product;

/**
 * Reviews are admin-curated social proof, not customer-submitted (Phase 1
 * fidelity decision: no public submission form, no moderation queue — the
 * reference's own back-office only lets an admin set how many reviews a
 * product should show). Setting reviews_count on a product syncs its
 * review rows to that count, generating or trimming as needed.
 */
class ReviewGenerator
{
    private const AUTHORS = [
        ['name' => 'Camille D.', 'country' => 'FR'],
        ['name' => 'Julien M.', 'country' => 'BE'],
        ['name' => 'Sophie L.', 'country' => 'FR'],
        ['name' => 'Antoine R.', 'country' => 'CH'],
        ['name' => 'Marie-Claire P.', 'country' => 'FR'],
        ['name' => 'Thomas B.', 'country' => 'LU'],
        ['name' => 'Nicolas F.', 'country' => 'FR'],
        ['name' => 'Aurélie G.', 'country' => 'CA'],
    ];

    private const COMMENTS = [
        "Très belle finition, le produit est encore plus beau en vrai qu'en photo.",
        "Bon rapport qualité-prix, la livraison était rapide et soignée.",
        "Exactement ce que je cherchais, je recommande sans hésiter.",
        "Belle pièce, conforme à la description. Un investissement qui en vaut la peine.",
        "Coup de cœur ! La qualité des matériaux se sent tout de suite.",
        "Très satisfait de mon achat, solide et bien fini.",
        "Livraison rapide, emballage soigné, produit conforme.",
        "Je recommande, le service client a été très réactif à mes questions.",
    ];

    public static function syncCount(Product $product, int $count): void
    {
        $count = max(0, $count);
        $current = $product->reviews()->count();

        if ($count < $current) {
            $product->reviews()
                ->latest('id')
                ->take($current - $count)
                ->get()
                ->each(fn ($review) => $review->delete());

            return;
        }

        for ($i = $current; $i < $count; $i++) {
            $author = self::AUTHORS[array_rand(self::AUTHORS)];

            $product->reviews()->create([
                'author_name' => $author['name'],
                'country' => $author['country'],
                'rating' => random_int(3, 5),
                'comment' => self::COMMENTS[array_rand(self::COMMENTS)],
            ]);
        }
    }
}
