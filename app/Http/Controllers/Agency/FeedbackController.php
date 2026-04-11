<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreClientFeedbackRequest;
use App\Services\FeedbackService;
use Illuminate\Http\RedirectResponse;

class FeedbackController extends Controller
{
    public function __construct(
        protected FeedbackService $feedbackService
    ) {
    }

    public function store(StoreClientFeedbackRequest $request): RedirectResponse
    {
        $feedback = $this->feedbackService->upsert($request->validated(), $request->user());

        return redirect()
            ->route('agency.clients.show', $feedback->client_id)
            ->with('message', 'Client feedback saved successfully.');
    }
}

