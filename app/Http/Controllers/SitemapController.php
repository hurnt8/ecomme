<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', 3600, function () {
            $staticPaths = [
                '/', '/boutique', '/blog', '/contact', '/suivi',
                '/a-propos', '/carrieres', '/presse', '/aide',
                '/mentions-legales', '/confidentialite', '/cookies', '/accessibilite',
                '/livraison', '/retours', '/moyens-paiement', '/cgv',
            ];

            $urls = collect($staticPaths)->map(fn (string $path) => [
                'loc' => url($path),
                'lastmod' => null,
            ]);

            $urls = $urls
                ->concat(Product::query()->active()->get(['slug', 'updated_at'])->map(fn (Product $product) => [
                    'loc' => url('/produit/'.$product->slug),
                    'lastmod' => $product->updated_at,
                ]))
                ->concat(BlogPost::query()->published()->get(['slug', 'updated_at'])->map(fn (BlogPost $post) => [
                    'loc' => url('/blog/'.$post->slug),
                    'lastmod' => $post->updated_at,
                ]));

            return view('sitemap', ['urls' => $urls])->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
