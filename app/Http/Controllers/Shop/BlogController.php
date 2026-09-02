<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('shop.blog-index', [
            'posts' => BlogPost::published()->latest('published_at')->paginate(6),
        ]);
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->published_at && $post->published_at->isPast(), 404);

        return view('shop.blog-show', [
            'post' => $post,
            'related' => BlogPost::published()
                ->where('id', '!=', $post->id)
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
