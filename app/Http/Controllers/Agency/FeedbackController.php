<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreClientFeedbackRequest;
use App\Models\ClientFeedback;
use Illuminate\Http\RedirectResponse;

class FeedbackController extends Controller
{
    public function store(StoreClientFeedbackRequest $request): RedirectResponse
    {
        $feedback = ClientFeedback::query()->updateOrCreate(
            [
                'client_id' => $request->integer('client_id'),
                'agency_user_id' => auth()->id(),
            ],
            [
                'rating' => $request->integer('rating'),
                'feedback_text' => $request->input('feedback_text'),
                'status' => ClientFeedback::STATUS_VISIBLE,
                'moderated_by' => null,
                'moderated_at' => null,
            ]
        );

        return redirect()->route('agency.clients.show', $feedback->client_id)->with('message', 'Feedback saved successfully.');
    }
}
