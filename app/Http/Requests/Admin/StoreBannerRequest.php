<?php

namespace App\Http\Requests\Admin;

use App\Models\Banner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBannerRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'image' => ['required', 'image', 'max:4096', 'dimensions:min_width=400,min_height=100,max_width=4000,max_height=4000'],
            'link_url' => ['nullable', 'string', 'max:255'],
            'position' => ['required', Rule::in(Banner::POSITIONS)],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
