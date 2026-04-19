<?php

namespace App\Http\Requests\Admin;

use App\Models\DisputeCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisputeCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        /** @var DisputeCategory $category */
        $category = $this->route('dispute_category');

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('dispute_categories', 'slug')->ignore($category?->id),
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}

