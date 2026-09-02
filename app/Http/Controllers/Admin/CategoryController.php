<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category,
            'categories' => Category::ordered()->get(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = Category::create([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug') ?: Str::slug($request->validated('name')),
            'description' => $request->validated('description'),
            'parent_id' => $request->validated('parent_id'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->validated('sort_order') ?? 0,
        ]);

        if ($request->hasFile('image')) {
            $category->update(['image' => $request->file('image')->store('categories', 'public')]);
        }

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie créée.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::where('id', '!=', $category->id)->ordered()->get(),
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update([
            'name' => $request->validated('name'),
            'slug' => $request->validated('slug') ?: $category->slug,
            'description' => $request->validated('description'),
            'parent_id' => $request->validated('parent_id'),
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->validated('sort_order') ?? 0,
        ]);

        if ($request->hasFile('image')) {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->update(['image' => $request->file('image')->store('categories', 'public')]);
        }

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie mise à jour.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return back()->with('toast', [
                'message' => 'Impossible de supprimer une catégorie qui contient des produits.',
                'type' => 'error',
            ]);
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Catégorie supprimée.');
    }
}
