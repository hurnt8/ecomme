<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
        $categoryId = $this->route('category')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096', 'dimensions:min_width=200,min_height=200,max_width=4000,max_height=4000'],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', Rule::notIn([$categoryId])],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
