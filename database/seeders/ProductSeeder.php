<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * The shop's catalogue.
 *
 * The whole of the supplier's range (guerrini-biomasse.com) is resold here, so the catalogue is
 * imported rather than typed: data/catalogue.json holds every product — name, price, description,
 * stock and its full gallery — and this seeder's job is to load it, not to carry it. Four thousand
 * products written out as a PHP array would be a multi-megabyte file nobody could review.
 *
 * Two things here are ours rather than the supplier's:
 *
 *   - data/authored-copy.php holds the hundred and twenty descriptions written for this shop.
 *     Keyed by primary photograph, they override the imported text for those products.
 *   - The ranges. The supplier files a product under several overlapping categories at once;
 *     catalogue.json resolves each to exactly one shop range, and CategorySeeder names them.
 *
 * Imported descriptions are the supplier's own, cleaned of the gallery-widget debris their feed
 * carries (bare `cloudzoom=` attribute soup, half-closed tags, raw image URLs).
 *
 * Photo files live in seeders/assets/products as gb-<supplier id>.<ext> for a product's primary
 * shot and gb-<supplier id>-2, -3 … for the rest, named by supplier id rather than by slug
 * because model names repeat across manufacturers.
 */
class ProductSeeder extends Seeder
{
    /**
     * Rows held before flushing. Inserting four thousand products and fifteen thousand image rows
     * one statement at a time takes minutes; batching turns it into seconds.
     */
    private const CHUNK = 250;

    public function run(): void
    {
        $catalogue = json_decode(
            file_get_contents(__DIR__.'/data/catalogue.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $authored = require __DIR__.'/data/authored-copy.php';

        $categoryIds = Category::query()->pluck('id', 'slug');

        $missingRanges = [];
        $skippedWithoutImages = 0;
        $seeded = [];
        $assets = __DIR__.'/assets/products';

        foreach (array_chunk($catalogue, self::CHUNK) as $chunk) {
            $rows = [];
            $now = now();

            foreach ($chunk as $item) {
                $categoryId = $categoryIds[$item['range']] ?? null;
                if ($categoryId === null) {
                    $missingRanges[$item['range']] = true;

                    continue;
                }

                // The source catalogue carries 108 rows with no photography at all. A product tile
                // is a photo first, so those listed as placeholders among real ones — and the
                // catalogue reads as unfinished. Skipped at import rather than deleted afterwards,
                // or the next db:seed would bring them all back.
                if (empty($item['images'])) {
                    $skippedWithoutImages++;

                    continue;
                }

                $primary = $item['images'][0]['file'] ?? null;
                $copy = $primary !== null ? ($authored[$primary] ?? null) : null;

                $description = $copy['description'] ?? $item['description'];
                if (trim($description) === '') {
                    // Rather than an empty product page, say plainly that the detail is missing.
                    $description = 'Fiche technique détaillée disponible sur demande — appelez-nous avant de commander.';
                }

                $seeded[] = $item['slug'];

                $rows[] = [
                    'category_id' => $categoryId,
                    'name' => $copy['name'] ?? $item['name'],
                    'slug' => $item['slug'],
                    'description' => $description,
                    'price' => $item['price'],
                    'compare_at_price' => $item['compare_at_price'],
                    'sizes' => null,
                    'colors' => null,
                    'stock' => $copy['stock'] ?? $item['stock'],
                    'is_active' => true,
                    'is_new' => $copy['is_new'] ?? false,
                    'is_bestseller' => $copy['is_bestseller'] ?? false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if ($rows) {
                Product::query()->upsert(
                    $rows,
                    ['slug'],
                    ['category_id', 'name', 'description', 'price', 'compare_at_price', 'stock', 'is_active', 'is_new', 'is_bestseller', 'updated_at']
                );
            }
        }

        if ($missingRanges) {
            throw new \RuntimeException(
                'Rayons absents de CategorySeeder : '.implode(', ', array_keys($missingRanges))
            );
        }

        // Reported rather than silent: a shrinking catalogue with no explanation looks like a bug.
        if ($skippedWithoutImages > 0) {
            $this->command?->info("{$skippedWithoutImages} produits ignorés : aucune photo dans le catalogue source.");
        }

        // Images, in a second pass so the product ids are known, and in bulk for the same reason
        // as above.
        $idsBySlug = Product::query()->pluck('id', 'slug');

        $copied = 0;
        $absent = 0;

        foreach (array_chunk($catalogue, self::CHUNK) as $chunk) {
            $productIds = [];
            foreach ($chunk as $item) {
                if (isset($idsBySlug[$item['slug']])) {
                    $productIds[] = $idsBySlug[$item['slug']];
                }
            }

            ProductImage::query()->whereIn('product_id', $productIds)->delete();

            $imageRows = [];
            foreach ($chunk as $item) {
                $productId = $idsBySlug[$item['slug']] ?? null;
                if ($productId === null) {
                    continue;
                }

                $position = 0;
                foreach ($item['images'] as $image) {
                    $file = $image['file'];
                    $path = 'products/'.$file;

                    // A product whose photo never downloaded is listed without it rather than
                    // dropped: Product::thumbnail_url falls back to a neutral placeholder.
                    if (! is_file($assets.'/'.$file)) {
                        $absent++;

                        continue;
                    }

                    if (! Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->put($path, file_get_contents($assets.'/'.$file));
                        $copied++;
                    }

                    $imageRows[] = [
                        'product_id' => $productId,
                        'path' => $path,
                        'position' => $position++,
                    ];
                }
            }

            foreach (array_chunk($imageRows, 500) as $batch) {
                DB::table('product_images')->insert($batch);
            }
        }

        // Products from an earlier version of this catalogue — the furniture range this shop sold
        // before the change of trade, and the curated selection that preceded the full import —
        // would otherwise survive re-seeding. Order history is unaffected: order_items snapshots
        // product_name and unit_price, and its product_id is nullOnDelete.
        $seededSet = array_flip($seeded);
        Product::query()
            ->select('id', 'slug')
            ->chunkById(500, function ($products) use ($seededSet) {
                $stale = $products->reject(fn (Product $p) => isset($seededSet[$p->slug]))->pluck('id');
                if ($stale->isNotEmpty()) {
                    ProductImage::query()->whereIn('product_id', $stale)->delete();
                    Product::query()->whereIn('id', $stale)->delete();
                }
            });

        $this->command?->info(sprintf(
            '  %d produits · %d photos copiées · %d photos absentes du disque',
            count($seeded),
            $copied,
            $absent
        ));
    }
}
