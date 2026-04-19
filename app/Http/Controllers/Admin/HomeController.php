<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // ── Summary stats ─────────────────────────────────────
        $stats = [
            'agencies'           => User::where('role', User::ROLE_AGENCY)->count(),
            'suspended_agencies' => User::where('role', User::ROLE_AGENCY)->where('status', User::STATUS_SUSPENDED)->count(),
            'verified_agencies'  => User::where('role', User::ROLE_AGENCY)->whereNotNull('email_verified_at')->count(),
            'total_clients'      => Client::count(),
            'visible_disputes'   => Dispute::where('status', Dispute::STATUS_VISIBLE)->count(),
            'hidden_disputes'    => Dispute::where('status', Dispute::STATUS_HIDDEN)->count(),
            'pending_disputes'   => Dispute::where('status', 'pending')->count(),
            'visible_feedback'   => ClientFeedback::where('status', ClientFeedback::STATUS_VISIBLE)->count(),
            'hidden_feedback'    => ClientFeedback::where('status', ClientFeedback::STATUS_HIDDEN)->count(),
            'pending_feedback'   => ClientFeedback::where('status', 'pending')->count(),
        ];

        // ── Last 6 months labels ───────────────────────────────
        $months      = collect(range(5, 0))->map(fn($i) => now()->subMonths($i)->startOfMonth());
        $monthLabels = $months->map(fn($m) => $m->format('M Y'))->values();
        $monthKeys   = $months->map(fn($m) => $m->format('Y-m'))->values();

        $fillMonths = fn($rows) => $monthKeys->map(
            fn($key) => $rows->firstWhere('month', $key)?->count ?? 0
        )->values()->toArray();

        // ── Agency registrations per month ────────────────────
        $agencyRegRows = User::where('role', User::ROLE_AGENCY)
            ->where('created_at', '>=', $months->first())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')->orderBy('month')
            ->get();
        $agencyRegData = $fillMonths($agencyRegRows);

        // ── Disputes per month ────────────────────────────────
        $disputeRows = Dispute::where('created_at', '>=', $months->first())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')->orderBy('month')
            ->get();
        $disputeData = $fillMonths($disputeRows);

        // ── Feedback per month ────────────────────────────────
        $feedbackRows = ClientFeedback::where('created_at', '>=', $months->first())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')->orderBy('month')
            ->get();
        $feedbackData = $fillMonths($feedbackRows);

        // ── Dispute status breakdown ──────────────────────────
        $disputeStatusRows = Dispute::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')->get()->keyBy('status');
        $disputeStatusData = [
            $disputeStatusRows['visible']->count  ?? 0,
            $disputeStatusRows['hidden']->count   ?? 0,
            $disputeStatusRows['pending']->count  ?? 0,
        ];

        // ── Feedback rating distribution ──────────────────────
        $ratingRows = ClientFeedback::where('status', ClientFeedback::STATUS_VISIBLE)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')->orderBy('rating')->get()->keyBy('rating');
        $ratingData = collect(range(1, 5))
            ->map(fn($r) => $ratingRows[$r]->count ?? 0)->values()->toArray();

        // ── Agency status breakdown ───────────────────────────
        $agencyActiveCount    = User::where('role', User::ROLE_AGENCY)->where('status', User::STATUS_ACTIVE)->count();
        $agencySuspendedCount = User::where('role', User::ROLE_AGENCY)->where('status', User::STATUS_SUSPENDED)->count();

        return view('home', compact(
            'stats',
            'monthLabels',
            'agencyRegData',
            'disputeData',
            'feedbackData',
            'disputeStatusData',
            'ratingData',
            'agencyActiveCount',
            'agencySuspendedCount',
        ));
    }
}
