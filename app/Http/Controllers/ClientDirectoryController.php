<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientFeedback;
use App\Models\Dispute;
use App\Services\ClientReputationService;
use App\Services\ClientSearchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientDirectoryController extends Controller
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

        return view('public.clients.index', compact('clients'));
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

        return view('public.clients.show', compact('client', 'summary', 'disputes', 'feedbackItems'));
    }
}

