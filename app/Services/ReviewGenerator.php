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
        'Gutes Preis-Leistungs-Verhältnis, die Lieferung war schnell und sorgfältig.',
        'Genau das, was ich gesucht habe, klare Empfehlung.',
        'Schönes Stück, wie beschrieben. Eine Investition, die sich lohnt.',
        'Ein Volltreffer! Die Materialqualität merkt man sofort.',
        'Sehr zufrieden mit dem Kauf, robust und sauber verarbeitet.',
        'Schnelle Lieferung, sorgfältige Verpackung, Ware wie beschrieben.',
        'Empfehlenswert, der Kundenservice hat sehr schnell auf meine Fragen reagiert.',
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
