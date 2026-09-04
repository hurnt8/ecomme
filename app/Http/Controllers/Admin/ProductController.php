<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ReviewGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with(['category', 'images'])
            ->withCount('reviews')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->string('search').'%'))
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($q2) => $q2->where('slug', $request->string('category'))))
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $product = Product::create([
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => ($data['slug'] ?? null) ?: Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'compare_at_price' => $data['compare_at_price'] ?? null,
            'sizes' => $this->parseTags($data['sizes'] ?? null),
            'colors' => $this->parseTags($data['colors'] ?? null),
            'stock' => $data['stock'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'is_new' => $request->boolean('is_new'),
            'is_bestseller' => $request->boolean('is_bestseller'),
        ]);

        $this->storeImages($request, $product);

        if (array_key_exists('reviews_count', $data)) {
            ReviewGenerator::syncCount($product, (int) $data['reviews_count']);
        }

        return redirect()->route('admin.produits.edit', $product)
            ->with('status', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        $product->load(['images', 'reviews']);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        $product->update([
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => ($data['slug'] ?? null) ?: $product->slug,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'compare_at_price' => $data['compare_at_price'] ?? null,
            'sizes' => $this->parseTags($data['sizes'] ?? null),
            'colors' => $this->parseTags($data['colors'] ?? null),
            'stock' => $data['stock'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'is_new' => $request->boolean('is_new'),
            'is_bestseller' => $request->boolean('is_bestseller'),
        ]);

        $this->storeImages($request, $product);

        if (array_key_exists('reviews_count', $data)) {
            ReviewGenerator::syncCount($product, (int) $data['reviews_count']);
        }

        return redirect()->route('admin.produits.edit', $product)
            ->with('status', 'Produit mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            $this->deleteStoredImage($image->path);
        }

        $product->delete();

        return redirect()->route('admin.produits.index')->with('status', 'Produit supprimé.');
    }

    public function destroyImage(Product $product, ProductImage $image): RedirectResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        $this->deleteStoredImage($image->path);
        $image->delete();

        $product->images()->orderBy('position')->get()->values()
            ->each(fn (ProductImage $img, int $index) => $img->position === $index ? null : $img->update(['position' => $index]));

        return back()->with('status', 'Image supprimée.');
    }

    public function setMainImage(Product $product, ProductImage $image): RedirectResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        $others = $product->images()->where('id', '!=', $image->id)->orderBy('position')->get();
        $image->update(['position' => 0]);

        foreach ($others as $index => $other) {
            $other->update(['position' => $index + 1]);
        }

        return back()->with('status', 'Image principale mise à jour.');
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        // (int) casts a null max() to 0 before the +1, which would skip
        // position 0 entirely for a brand new product's first image — the
        // null-coalesce has to happen before the increment, not after.
        $position = (int) ($product->images()->max('position') ?? -1) + 1;

        foreach ($request->file('images') as $file) {
            $path = $file->store('products', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'position' => $position++,
            ]);
        }
    }

    private function deleteStoredImage(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function parseTags(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        $tags = array_values(array_filter(array_map('trim', explode(',', $value))));

        return $tags ?: null;
    }
}
