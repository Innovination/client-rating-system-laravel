<?php

namespace App\Http\Requests\Admin;

use App\Models\Dispute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModerateDisputeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([Dispute::STATUS_VISIBLE, Dispute::STATUS_HIDDEN])],
            'reason' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

