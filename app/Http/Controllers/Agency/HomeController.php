<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $agency = auth()->user();

        $stats = [
            'profile_completed' => (bool) $agency->agencyProfile,
            'clients_added' => Client::query()->where('created_by', $agency->id)->count(),
            'notifications_unread' => $agency->unreadNotifications()->count(),
        ];

        $recentClients = Client::query()
            ->where('created_by', $agency->id)
            ->select(['id', 'name', 'location', 'created_at'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('agency.home', compact('stats', 'recentClients'));
    }
}
