<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->user_type === 'agency';
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback_text' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
