<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\UpdateAgencyProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = auth()->user()->agencyProfile;

        return view('agency.profile.edit', compact('profile'));
    }

    public function update(UpdateAgencyProfileRequest $request): RedirectResponse
    {
        auth()->user()->agencyProfile()->updateOrCreate(
            ['user_id' => auth()->id()],
            $request->validated()
        );

        return redirect()->route('agency.profile.edit')->with('message', 'Agency profile updated successfully.');
    }
}
