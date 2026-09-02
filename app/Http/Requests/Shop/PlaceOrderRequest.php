<?php

namespace App\Http\Requests\Shop;

use App\Support\Countries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlaceOrderRequest extends FormRequest
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
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'string', 'email', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:120'],
            'country' => ['required', 'string', Rule::in(array_keys(Countries::LIST))],
        ];
    }

    /**
     * @return array{name: string, email: string, address: string, country: string}
     */
    public function customer(): array
    {
        $country = strtoupper($this->string('country')->toString());

        return [
            'name' => $this->string('customer_name')->toString(),
            'email' => $this->string('customer_email')->toString(),
            'address' => implode("\n", [
                $this->string('address_line1')->toString(),
                $this->string('postal_code').' '.$this->string('city'),
                Countries::label($country) ?? $country,
            ]),
            'country' => $country,
        ];
    }
}
