<?php

namespace App\Http\Requests\Admin;

use App\Models\ClientFeedback;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModerateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([ClientFeedback::STATUS_VISIBLE, ClientFeedback::STATUS_HIDDEN])],
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

