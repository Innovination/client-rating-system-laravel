<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModerateDisputeRequest;
use App\Http\Requests\Admin\ModerateFeedbackRequest;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Services\ModerationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function __construct(
        protected ModerationService $moderationService
    ) {
    }

    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $status = in_array($status, [Dispute::STATUS_VISIBLE, Dispute::STATUS_HIDDEN], true) ? $status : null;

        $disputes = Dispute::query()
            ->with(['client', 'agency.agencyProfile', 'category', 'moderator'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20, ['*'], 'disputes_page')
            ->withQueryString();

        $feedbackItems = ClientFeedback::query()
            ->with(['client', 'agency.agencyProfile', 'moderator'])
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(20, ['*'], 'feedback_page')
            ->withQueryString();

        return view('admin.moderation.index', compact('disputes', 'feedbackItems', 'status'));
    }

    public function updateDispute(ModerateDisputeRequest $request, Dispute $dispute): RedirectResponse
    {
        $this->moderationService->moderateDispute(
            admin: $request->user(),
            dispute: $dispute,
            status: $request->validated('status'),
            reason: $request->validated('reason')
        );

        return back()->with('message', 'Dispute moderation updated.');
    }

    public function destroyDispute(Request $request, Dispute $dispute): RedirectResponse
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:1000']]);

        $this->moderationService->deleteDispute(
            admin: $request->user(),
            dispute: $dispute,
            reason: $request->input('reason')
        );

        return back()->with('message', 'Dispute removed.');
    }

    public function updateFeedback(ModerateFeedbackRequest $request, ClientFeedback $feedback): RedirectResponse
    {
        $this->moderationService->moderateFeedback(
            admin: $request->user(),
            feedback: $feedback,
            status: $request->validated('status'),
            reason: $request->validated('reason')
        );

        return back()->with('message', 'Feedback moderation updated.');
    }

    public function destroyFeedback(Request $request, ClientFeedback $feedback): RedirectResponse
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:1000']]);

        $this->moderationService->deleteFeedback(
            admin: $request->user(),
            feedback: $feedback,
            reason: $request->input('reason')
        );

        return back()->with('message', 'Feedback removed.');
    }
}

