<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreDisputeRequest;
use App\Services\DisputeSubmissionService;
use Illuminate\Http\RedirectResponse;

class DisputeController extends Controller
{
    public function __construct(
        protected DisputeSubmissionService $disputeSubmissionService
    ) {
    }

    public function store(StoreDisputeRequest $request): RedirectResponse
    {
        $dispute = $this->disputeSubmissionService->submit($request->validated(), $request->user());

        return redirect()
            ->route('agency.clients.show', $dispute->client_id)
            ->with('message', 'Dispute submitted successfully.');
    }
}

