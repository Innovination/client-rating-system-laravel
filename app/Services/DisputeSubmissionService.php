<?php

namespace App\Services;

use App\Models\Dispute;
use App\Models\User;

class DisputeSubmissionService
{
    public function submit(array $validated, User $agency): Dispute
    {
        return Dispute::create([
            'client_id' => $validated['client_id'],
            'agency_user_id' => $agency->id,
            'dispute_category_id' => $validated['dispute_category_id'] ?? null,
            'project_type' => $validated['project_type'],
            'dispute_type' => $validated['dispute_type'],
            'issue_description' => $validated['issue_description'],
            'supporting_notes' => $validated['supporting_notes'] ?? null,
            'status' => Dispute::STATUS_VISIBLE,
        ]);
    }
}

