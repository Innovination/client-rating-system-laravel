<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisputeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->user_type === 'agency';
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'dispute_category_id' => ['nullable', 'integer', 'exists:dispute_categories,id'],
            'project_type' => ['required', 'string', 'max:255'],
            'dispute_type' => ['required', 'string', 'max:255'],
            'issue_description' => ['required', 'string', 'max:5000'],
            'supporting_notes' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
