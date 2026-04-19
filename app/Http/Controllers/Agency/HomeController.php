<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'clients_added' => Client::query()->where('created_by', $user->id)->count(),
            'disputes_submitted' => Dispute::query()->where('agency_user_id', $user->id)->count(),
            'feedback_submitted' => ClientFeedback::query()->where('agency_user_id', $user->id)->count(),
            'is_verified' => ! is_null($user->email_verified_at),
            'status' => $user->status,
        ];

        return view('agency.home', compact('stats'));
    }
}
