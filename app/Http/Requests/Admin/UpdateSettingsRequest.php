<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'legal_form' => ['nullable', 'string', 'max:255'],
            // Spaces are accepted and kept: "981 826 803" is how the RNE publishes it and how it
            // is expected to read on an invoice. Length is checked on digits only.
            'siren' => ['nullable', 'string', 'max:20', 'regex:/^(\d[\s.]*){9}$/'],
            'siret' => ['nullable', 'string', 'max:20', 'regex:/^(\d[\s.]*){14}$/'],
            'vat_number' => ['nullable', 'string', 'max:20'],
            'naf_code' => ['nullable', 'string', 'max:10'],
            'naf_label' => ['nullable', 'string', 'max:255'],
            'registered_address' => ['nullable', 'string', 'max:255'],
            'publication_director' => ['nullable', 'string', 'max:255'],
            'host_details' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048', 'dimensions:max_width=2000,max_height=2000'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_twitter' => ['nullable', 'url', 'max:255'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:1'],
            'free_shipping_threshold' => ['required', 'numeric', 'min:0'],
            'international_shipping_fee' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'announcement_text' => ['nullable', 'string', 'max:255'],
            'sale_ends_at' => ['nullable', 'date'],
            'bank_account_holder' => ['nullable', 'string', 'max:255'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_iban' => ['nullable', 'string', 'max:50'],
            'bank_bic' => ['nullable', 'string', 'max:20'],
            'notify_new_orders' => ['nullable', 'boolean'],
            'notification_email' => ['nullable', 'email', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'siren.regex' => 'Le SIREN doit comporter 9 chiffres (exemple : 981 826 803).',
            'siret.regex' => 'Le SIRET doit comporter 14 chiffres (exemple : 981 826 803 00018).',
        ];
    }
}
