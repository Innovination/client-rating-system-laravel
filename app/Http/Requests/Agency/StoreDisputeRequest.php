<?php

namespace App\Http\Requests\Agency;

use App\Models\DisputeCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDisputeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'dispute_category_id' => [
                'nullable',
                'integer',
                Rule::exists('dispute_categories', 'id')->where(
                    fn ($query) => $query->where('is_active', true)
                ),
            ],
            'project_type' => ['required', 'string', 'max:255'],
            'dispute_type' => ['required', 'string', 'max:255'],
            'issue_description' => ['required', 'string', 'max:5000'],
            'supporting_notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}

