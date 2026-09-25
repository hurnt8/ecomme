<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Resolves the stored path to a public URL, matching Banner::imageUrl(). A category image is
     * optional (the admin form allows saving without one), so this returns null rather than a
     * URL pointing at nothing — callers fall back to a product photo.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? Storage::disk('public')->url($this->image) : null,
        );
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * The ranges the shop promotes while it is cold: wood and pellets to burn, the saws that cut
     * them, and the stoves and outdoor fires they feed.
     *
     * It lives on the model because the homepage carousels and the catalogue's default ordering
     * both key off it. A spring reshuffle changes this one list, not a copy in each controller —
     * and a copy that drifts is exactly how a shop ends up promoting pellets in July on one page
     * and mowers on another.
     *
     * @return array<int, string>
     */
    public static function coldSeasonSlugs(): array
    {
        return ['bois-chauffage', 'tronconneuses-elagage', 'barbecues-fours'];
    }
}
