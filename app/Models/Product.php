<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Shown when a product has no photograph yet. Drawn inline rather than served as a file so
     * it can never 404, and deliberately neutral: the previous fallback pointed at
     * template/images/product-1.jpg, so any product still awaiting photography was illustrated
     * with the concrete rocking chair as though that were the item.
     */
    private const PHOTO_PLACEHOLDER = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 300" role="img">
            <rect width="400" height="300" fill="#f2f0ec"/>
            <g fill="none" stroke="#cbc5b4" stroke-width="5" stroke-linejoin="round">
                <rect x="142" y="104" width="116" height="88" rx="6"/>
                <circle cx="173" cy="133" r="9"/>
                <path d="M148 184l36-32 28 24 21-17 19 25"/>
            </g>
            <text x="200" y="226" text-anchor="middle" font-family="Helvetica, Arial, sans-serif"
                  font-size="15" fill="#a9a294">Photo à venir</text>
        </svg>
        SVG;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'sizes',
        'colors',
        'stock',
        'is_active',
        'is_new',
        'is_bestseller',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'sizes' => 'array',
            'colors' => 'array',
            'is_active' => 'boolean',
            'is_new' => 'boolean',
            'is_bestseller' => 'boolean',
        ];
    }

    /**
     * The image to show for this product anywhere a single thumbnail is needed, falling back to
     * the placeholder above so a product without photography never borrows another's.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->images->first()?->url
                ?? 'data:image/svg+xml;charset=utf-8,'.rawurlencode(trim(self::PHOTO_PLACEHOLDER)),
        );
    }

    public function hasPhoto(): bool
    {
        return $this->images->isNotEmpty();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOnSale(Builder $query): Builder
    {
        return $query->whereNotNull('compare_at_price')
            ->whereColumn('compare_at_price', '>', 'price');
    }

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('is_new', true);
    }

    public function scopeBestseller(Builder $query): Builder
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeWithRatings(Builder $query): Builder
    {
        return $query->withCount('reviews')->withAvg('reviews', 'rating');
    }
}
