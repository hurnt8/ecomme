<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'site_name',
        'legal_name',
        'legal_form',
        'siren',
        'siret',
        'vat_number',
        'naf_code',
        'naf_label',
        'registered_address',
        'publication_director',
        'branch_label',
        'branch_address',
        'host_details',
        'logo',
        'tagline',
        'description',
        'contact_email',
        'contact_phone',
        'contact_address',
        'whatsapp_number',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'tax_rate',
        'free_shipping_threshold',
        'international_shipping_fee',
        'currency',
        'sale_ends_at',
        'announcement_text',
        'bank_account_holder',
        'bank_name',
        'bank_iban',
        'bank_bic',
        'notify_new_orders',
        'notification_email',
    ];

    protected function casts(): array
    {
        return [
            'tax_rate' => 'decimal:4',
            'free_shipping_threshold' => 'decimal:2',
            'international_shipping_fee' => 'decimal:2',
            'sale_ends_at' => 'datetime',
            'notify_new_orders' => 'boolean',
        ];
    }

    /**
     * Resolves the uploaded logo to a public URL, matching Category::imageUrl(). The column and
     * the admin upload field both already existed, but nothing ever read them: the shop header
     * printed site_name as text whatever had been uploaded, so a logo could be saved from the
     * back-office and never appear anywhere on the public site.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->logo ? Storage::disk('public')->url($this->logo) : null,
        );
    }

    /**
     * The display symbol for `currency`, which is stored as an ISO code. Shop pages that quote a
     * price in running text should use this so they read "150 €" like the price component does,
     * rather than "150 EUR". PDFs deliberately keep the ISO code (dompdf's default fonts don't
     * carry every currency glyph).
     */
    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency) {
            'EUR' => '€',
            'USD' => '$',
            'GBP' => '£',
            default => (string) $this->currency,
        };
    }

    /**
     * The settings table only ever holds a single row (id=1). Prefer
     * `SettingsService::current()` in application code — it adds the cache
     * layer described in the Fondations plan; this accessor is what that
     * service (and the seeder) calls under the hood.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
