<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\StoreDisputeRequest;
use App\Models\Dispute;
use Illuminate\Http\RedirectResponse;

class DisputeController extends Controller
{
    public function store(StoreDisputeRequest $request): RedirectResponse
    {
        $dispute = Dispute::create([
            ...$request->validated(),
            'agency_user_id' => auth()->id(),
            'status' => Dispute::STATUS_VISIBLE,
        ]);

        return redirect()->route('agency.clients.show', $dispute->client_id)->with('message', 'Dispute submitted successfully.');
    }
}
