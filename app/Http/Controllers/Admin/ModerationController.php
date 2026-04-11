<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerationController extends Controller
{
    public function index(Request $request): View
    {
        $disputes = Dispute::query()
            ->with(['client:id,name', 'agency:id,name,email'])
            ->latest()
            ->paginate(20, ['*'], 'disputes_page');

        $feedback = ClientFeedback::query()
            ->with(['client:id,name', 'agency:id,name,email'])
            ->latest()
            ->paginate(20, ['*'], 'feedback_page');

        return view('admin.moderation.index', compact('disputes', 'feedback'));
    }

    public function hideDispute(Dispute $dispute): RedirectResponse
    {
        $dispute->update([
            'status' => Dispute::STATUS_HIDDEN,
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return back()->with('message', 'Dispute hidden successfully.');
    }

    public function restoreDispute(Dispute $dispute): RedirectResponse
    {
        $dispute->update([
            'status' => Dispute::STATUS_VISIBLE,
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return back()->with('message', 'Dispute restored successfully.');
    }

    public function deleteDispute(Dispute $dispute): RedirectResponse
    {
        $dispute->delete();

        return back()->with('message', 'Dispute removed successfully.');
    }

    public function hideFeedback(ClientFeedback $feedback): RedirectResponse
    {
        $feedback->update([
            'status' => ClientFeedback::STATUS_HIDDEN,
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return back()->with('message', 'Feedback hidden successfully.');
    }

    public function restoreFeedback(ClientFeedback $feedback): RedirectResponse
    {
        $feedback->update([
            'status' => ClientFeedback::STATUS_VISIBLE,
            'moderated_by' => auth()->id(),
            'moderated_at' => now(),
        ]);

        return back()->with('message', 'Feedback restored successfully.');
    }

    public function deleteFeedback(ClientFeedback $feedback): RedirectResponse
    {
        $feedback->delete();

        return back()->with('message', 'Feedback removed successfully.');
    }
}
