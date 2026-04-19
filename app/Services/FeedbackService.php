<?php

namespace App\Services;

use App\Models\ClientFeedback;
use App\Models\User;

class FeedbackService
{
    public function upsert(array $validated, User $agency): ClientFeedback
    {
        $feedback = ClientFeedback::withTrashed()
            ->where('client_id', $validated['client_id'])
            ->where('agency_user_id', $agency->id)
            ->first();

        if (! $feedback) {
            return ClientFeedback::create([
                'client_id' => $validated['client_id'],
                'agency_user_id' => $agency->id,
                'rating' => $validated['rating'],
                'feedback_text' => $validated['feedback_text'] ?? null,
                'status' => ClientFeedback::STATUS_VISIBLE,
            ]);
        }

        $feedback->fill([
            'rating' => $validated['rating'],
            'feedback_text' => $validated['feedback_text'] ?? null,
            'status' => ClientFeedback::STATUS_VISIBLE,
            'moderated_by' => null,
            'moderated_at' => null,
        ]);

        if ($feedback->trashed()) {
            $feedback->restore();
        }

        $feedback->save();

        return $feedback->refresh();
    }
}

