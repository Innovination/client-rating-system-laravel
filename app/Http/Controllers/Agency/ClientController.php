<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreAgencyClientRequest;
use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Models\DisputeCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $query = Client::query()
            ->select(['id', 'name', 'website', 'location', 'created_by', 'created_at'])
            ->with('createdBy:id,name,email')
            ->withCount('feedback');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $clients = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        return view('agency.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('agency.clients.create');
    }

    public function store(StoreAgencyClientRequest $request): RedirectResponse
    {
        $client = Client::create([
            ...$request->validated(),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('agency.clients.show', $client)->with('message', 'Client added successfully.');
    }

    public function show(Client $client): View
    {
        $client->load(['createdBy:id,name,email']);

        $disputes = $client->disputes()
            ->where('status', Dispute::STATUS_VISIBLE)
            ->with(['agency:id,name,email,mobile', 'category:id,name'])
            ->latest()
            ->take(10)
            ->get();

        $feedback = $client->feedback()
            ->where('status', ClientFeedback::STATUS_VISIBLE)
            ->with('agency:id,name,email,mobile')
            ->latest()
            ->take(10)
            ->get();

        $avgRating = round((float) $client->feedback()->where('status', ClientFeedback::STATUS_VISIBLE)->avg('rating'), 1);
        $myFeedback = $client->feedback()->where('agency_user_id', auth()->id())->first();
        $categories = DisputeCategory::query()->where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('agency.clients.show', compact('client', 'disputes', 'feedback', 'avgRating', 'myFeedback', 'categories'));
    }
}
