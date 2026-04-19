<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agency\UpdateAgencyProfileRequest;
use App\Models\AgencyProfile;
use App\Models\Country;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function show(): View
    {
        $profile = $this->getProfile();
        $this->authorize('view', $profile);

        return view('agency.profile.show', compact('profile'));
    }

    public function edit(): View
    {
        $profile = $this->getProfile();
        $this->authorize('update', $profile);

        $countries = Country::orderBy('name')->pluck('name', 'id');

        return view('agency.profile.edit', compact('profile', 'countries'));
    }

    public function update(UpdateAgencyProfileRequest $request): RedirectResponse
    {
        $profile = $this->getProfile();
        $this->authorize('update', $profile);

        $profile->update($request->safe()->except('email'));

        $request->user()->update([
            'email' => $request->validated('email'),
            'mobile' => $request->validated('phone'),
            'company_name' => $request->validated('company_name'),
            'name' => $request->validated('contact_person'),
        ]);

        return redirect()
            ->route('agency.profile.show')
            ->with('message', 'Agency profile updated successfully.');
    }

    protected function getProfile(): AgencyProfile
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return AgencyProfile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'company_name' => $user->company_name,
                'contact_person' => $user->name,
                'phone' => $user->mobile,
            ]
        );
    }
}

