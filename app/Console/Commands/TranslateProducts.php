<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Machine-translates the product catalogue in place.
 *
 * Written as a command rather than done inline because the catalogue is 11.6 million characters:
 * it has to run unattended, survive an interruption, and be re-runnable without paying twice for
 * the rows it already did. Hence --resume, the per-batch commit, and the progress file.
 *
 * Slugs are never touched. They are the published product URLs and the key the catalogue filters
 * and the seeder resolve products by; translating them would break every existing link.
 */
class TranslateProducts extends Command
{
    protected $signature = 'products:translate
        {--provider=deepl : deepl, google or libretranslate}
        {--key= : API key; falls back to DEEPL_API_KEY or GOOGLE_TRANSLATE_KEY in .env}
        {--host=http://127.0.0.1:5000 : LibreTranslate server, for --provider=libretranslate}
        {--target=DE : target language code}
        {--source=FR : source language code}
        {--batch=25 : products per API call}
        {--limit= : stop after this many products (for a trial run)}
        {--category= : restrict to one category slug}
        {--resume : skip products already recorded as translated}
        {--dry-run : translate nothing, just report what would be sent}';

    protected $description = 'Traduit les noms et descriptions des produits via DeepL ou Google Translate.';

    /** Where the ids of already-translated products are recorded, one per line. */
    private string $progressFile;

    public function handle(): int
    {
        $this->progressFile = storage_path('app/products-translated.txt');

        $provider = strtolower((string) $this->option('provider'));
        if (! in_array($provider, ['deepl', 'google', 'libretranslate'], true)) {
            $this->error("Fournisseur inconnu : {$provider}. Utilisez deepl, google ou libretranslate.");

            return self::FAILURE;
        }

        $key = $this->option('key')
            ?: env($provider === 'deepl' ? 'DEEPL_API_KEY' : 'GOOGLE_TRANSLATE_KEY');

        // A self-hosted LibreTranslate needs no key at all, so the guard below must not stop it.
        if ($provider === 'libretranslate' && ! $key) {
            $key = '';
        }

        if ($key === null && ! $this->option('dry-run')) {
            $this->error('Aucune clé API. Passez --key=... ou renseignez '.($provider === 'deepl' ? 'DEEPL_API_KEY' : 'GOOGLE_TRANSLATE_KEY').' dans .env');

            return self::FAILURE;
        }

        $done = $this->option('resume') ? $this->alreadyDone() : [];

        $query = Product::query()->select(['id', 'name', 'description'])->orderBy('id');

        if ($slug = $this->option('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
        }

        if ($done !== []) {
            $query->whereNotIn('id', $done);
        }

        $total = (clone $query)->count();

        if ($limit = $this->option('limit')) {
            $total = min($total, (int) $limit);
        }

        if ($total === 0) {
            $this->info('Rien à traduire.');

            return self::SUCCESS;
        }

        $characters = (clone $query)->limit($total)->get()
            ->sum(fn (Product $p) => mb_strlen($p->name) + mb_strlen((string) $p->description));

        $this->info("Produits à traduire : {$total}");
        $this->info('Caractères         : '.number_format($characters, 0, ',', ' '));
        $this->info('Fournisseur        : '.$provider.'  '.$this->option('source').' → '.$this->option('target'));

        if ($this->option('dry-run')) {
            $this->warn('--dry-run : aucun appel API, aucune écriture.');

            return self::SUCCESS;
        }

        if (! $this->confirm('Lancer la traduction ?', true)) {
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $translated = 0;
        $failed = 0;

        // chunkById, not chunk: the rows are being written to as we go, and a plain offset-based
        // chunk would skip records as the result set shifts under it.
        (clone $query)->limit($total)->chunkById((int) $this->option('batch'), function ($products) use ($provider, $key, &$translated, &$failed, $bar) {
            /* Names and descriptions go in one flat list so a batch of 25 products is two API
             * calls at most, not fifty. */
            $payload = [];
            foreach ($products as $product) {
                $payload[] = $product->name;
                $payload[] = (string) $product->description;
            }

            try {
                $result = match ($provider) {
                    'deepl' => $this->deepl($payload, $key),
                    'google' => $this->google($payload, $key),
                    default => $this->libretranslate($payload, $key),
                };
            } catch (Throwable $e) {
                $failed += $products->count();
                $bar->advance($products->count());
                $this->newLine();
                $this->warn('Lot ignoré : '.$e->getMessage());

                return true;
            }

            foreach ($products as $i => $product) {
                $name = $result[$i * 2] ?? null;
                $description = $result[$i * 2 + 1] ?? null;

                if ($name === null) {
                    $failed++;
                    $bar->advance();

                    continue;
                }

                // Written straight to the query builder: Product has no updated_at concerns here
                // and this avoids loading every model's relations for a two-column write.
                Product::query()->whereKey($product->id)->update([
                    'name' => $name,
                    'description' => $description !== '' ? $description : $product->description,
                ]);

                $this->recordDone($product->id);
                $translated++;
                $bar->advance();
            }

            return true;
        });

        $bar->finish();
        $this->newLine(2);
        $this->info("Traduits : {$translated}");

        if ($failed > 0) {
            $this->warn("Échecs   : {$failed} — relancez avec --resume pour reprendre.");
        }

        return self::SUCCESS;
    }

    /**
     * @param  array<int, string>  $texts
     * @return array<int, string>
     */
    private function deepl(array $texts, string $key): array
    {
        // Free keys end in ":fx" and live on a different host; sending them to the pro endpoint
        // returns 403 with no useful message.
        $host = str_ends_with($key, ':fx') ? 'api-free.deepl.com' : 'api.deepl.com';

        $response = Http::asForm()
            ->withHeaders(['Authorization' => 'DeepL-Auth-Key '.$key])
            ->timeout(120)
            ->retry(3, 2000)
            ->post("https://{$host}/v2/translate", [
                'text' => $texts,
                'source_lang' => strtoupper((string) $this->option('source')),
                'target_lang' => strtoupper((string) $this->option('target')),
                // Product copy carries "\n\n" paragraph breaks that must survive the round trip.
                'preserve_formatting' => '1',
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('DeepL '.$response->status().' : '.$response->body());
        }

        return array_map(
            fn (array $t) => $t['text'],
            $response->json('translations', [])
        );
    }

    /**
     * @param  array<int, string>  $texts
     * @return array<int, string>
     */
    private function google(array $texts, string $key): array
    {
        $response = Http::timeout(120)
            ->retry(3, 2000)
            ->post('https://translation.googleapis.com/language/translate/v2?key='.$key, [
                'q' => $texts,
                'source' => strtolower((string) $this->option('source')),
                'target' => strtolower((string) $this->option('target')),
                'format' => 'text',
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('Google '.$response->status().' : '.$response->body());
        }

        return array_map(
            fn (array $t) => html_entity_decode($t['translatedText'], ENT_QUOTES, 'UTF-8'),
            $response->json('data.translations', [])
        );
    }

    /**
     * Self-hosted LibreTranslate. No key, no quota, no per-character cost — but Argos ships no
     * direct fr→de model, so the server pivots through English and quality drops accordingly.
     * The timeout is generous because a local CPU translates far slower than a hosted API.
     *
     * @param  array<int, string>  $texts
     * @return array<int, string>
     */
    private function libretranslate(array $texts, string $key): array
    {
        $payload = [
            'q' => $texts,
            'source' => strtolower((string) $this->option('source')),
            'target' => strtolower((string) $this->option('target')),
            'format' => 'text',
        ];

        if ($key !== '') {
            $payload['api_key'] = $key;
        }

        $response = Http::timeout(600)
            ->retry(2, 5000)
            ->post(rtrim((string) $this->option('host'), '/').'/translate', $payload);

        if ($response->failed()) {
            throw new \RuntimeException('LibreTranslate '.$response->status().' : '.$response->body());
        }

        $translated = $response->json('translatedText');

        // The endpoint mirrors its input: an array of strings in, an array out. A single string
        // back means the server collapsed the batch, and pairing it to products would misalign
        // every row after the first.
        if (! is_array($translated)) {
            throw new \RuntimeException('LibreTranslate a renvoyé une réponse inattendue : '.$response->body());
        }

        return $translated;
    }

    /**
     * @return array<int, int>
     */
    private function alreadyDone(): array
    {
        if (! is_file($this->progressFile)) {
            return [];
        }

        return array_map('intval', array_filter(file($this->progressFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)));
    }

    private function recordDone(int $id): void
    {
        // Appended per product, not per batch: an interruption mid-batch must not lose the rows
        // that were already written and paid for.
        file_put_contents($this->progressFile, $id."\n", FILE_APPEND);
    }
}
