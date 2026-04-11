<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'agencies' => User::query()->where('role', User::ROLE_AGENCY)->count(),
            'suspended_agencies' => User::query()->where('role', User::ROLE_AGENCY)->where('status', User::STATUS_SUSPENDED)->count(),
            'visible_disputes' => Dispute::query()->where('status', Dispute::STATUS_VISIBLE)->count(),
            'hidden_disputes' => Dispute::query()->where('status', Dispute::STATUS_HIDDEN)->count(),
            'visible_feedback' => ClientFeedback::query()->where('status', ClientFeedback::STATUS_VISIBLE)->count(),
            'hidden_feedback' => ClientFeedback::query()->where('status', ClientFeedback::STATUS_HIDDEN)->count(),
        ];

        return view('home', compact('stats'));
    }
}
