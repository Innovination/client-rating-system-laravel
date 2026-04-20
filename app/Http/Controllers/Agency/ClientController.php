<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreClientRequest;
use App\Models\City;
use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Country;
use App\Models\Dispute;
use App\Models\DisputeCategory;
use App\Services\ClientReputationService;
use App\Services\ClientSearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(
        protected ClientSearchService $clientSearchService,
        protected ClientReputationService $clientReputationService
    ) {
    }

    public function index(Request $request): View
    {
        $clients = $this->clientSearchService->search(
            term: $request->string('q')->toString(),
            perPage: 15
        );

        return view('agency.clients.index', compact('clients'));
    }

    public function create(): View
    {
        $countries = Country::orderBy('name')->pluck('name', 'id');

        return view('agency.clients.create', compact('countries'));
    }

    public function store(StoreClientRequest $request): RedirectResponse
    {
        $client = Client::create([
            'name'       => $request->validated('name'),
            'website'    => $request->validated('website'),
            'phone'      => $request->validated('phone'),
            'address'    => $request->validated('address'),
            'country_id' => $request->validated('country_id'),
            'state_id'   => $request->validated('state_id'),
            'city_id'    => $request->validated('city_id'),
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('agency.clients.show', $client)
            ->with('message', 'Client created successfully.');
    }

    public function show(Client $client): View
    {
        $summary = $this->clientReputationService->getSummary($client);

        $disputes = Dispute::query()
            ->where('client_id', $client->id)
            ->where('status', Dispute::STATUS_VISIBLE)
            ->with(['agency.agencyProfile', 'category'])
            ->latest()
            ->paginate(10, ['*'], 'disputes_page');

        $feedbackItems = ClientFeedback::query()
            ->where('client_id', $client->id)
            ->where('status', ClientFeedback::STATUS_VISIBLE)
            ->with(['agency.agencyProfile'])
            ->latest()
            ->paginate(10, ['*'], 'feedback_page');

        $myFeedback = ClientFeedback::query()
            ->where('client_id', $client->id)
            ->where('agency_user_id', auth()->id())
            ->first();

        $categories = DisputeCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('agency.clients.show', compact('client', 'summary', 'disputes', 'feedbackItems', 'myFeedback', 'categories'));
    }
}

