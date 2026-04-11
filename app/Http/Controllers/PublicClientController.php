<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicClientController extends Controller
{
    public function index(Request $request): View
    {
        $query = Client::query()->select(['id', 'name', 'website', 'location', 'created_at']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $clients = $query->orderBy('name')->paginate(20)->appends($request->query());

        return view('public.clients.index', compact('clients'));
    }

    public function show(Client $client): View
    {
        $feedback = $client->feedback()
            ->where('status', ClientFeedback::STATUS_VISIBLE)
            ->with('agency:id,name,email,mobile')
            ->latest()
            ->paginate(10, ['*'], 'feedback_page');

        $disputes = $client->disputes()
            ->where('status', Dispute::STATUS_VISIBLE)
            ->with(['agency:id,name,email,mobile', 'category:id,name'])
            ->latest()
            ->paginate(10, ['*'], 'dispute_page');

        $avgRating = round((float) $client->feedback()->where('status', ClientFeedback::STATUS_VISIBLE)->avg('rating'), 1);

        return view('public.clients.show', compact('client', 'feedback', 'disputes', 'avgRating'));
    }
}
