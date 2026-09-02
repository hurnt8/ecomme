<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    public const POSITIONS = ['home_hero', 'home_secondary', 'shop_new', 'shop_sale', 'shop_all'];

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link_url',
        'position',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('public')->url($this->image),
        );
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeForPosition(Builder $query, string $position): Builder
    {
        return $query->where('position', $position)->orderBy('sort_order');
    }
}
