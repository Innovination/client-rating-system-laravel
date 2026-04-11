<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;

class ClientReputationService
{
    public function withSummaryMetrics(Builder $query): Builder
    {
        return $query
            ->withCount([
                'visibleFeedback as visible_feedback_count',
                'visibleDisputes as visible_disputes_count',
            ])
            ->withAvg('visibleFeedback as visible_feedback_avg', 'rating');
    }

    public function getSummary(Client $client): array
    {
        $feedbackQuery = $client->visibleFeedback();

        $feedbackCount = (int) $feedbackQuery->count();
        $averageRating = $feedbackCount > 0
            ? round((float) $feedbackQuery->avg('rating'), 1)
            : null;

        return [
            'feedback_count' => $feedbackCount,
            'average_rating' => $averageRating,
            'dispute_count' => (int) $client->visibleDisputes()->count(),
        ];
    }
}

