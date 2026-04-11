<?php

namespace App\Http\Requests\Agency;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback_text' => ['nullable', 'string', 'max:5000'],
        ];
    }
}

