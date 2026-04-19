<?php

namespace App\Policies;

use App\Models\AgencyProfile;
use App\Models\User;

class AgencyProfilePolicy
{
    public function view(User $user, AgencyProfile $agencyProfile): bool
    {
        return (int) $agencyProfile->user_id === (int) $user->id;
    }

    public function update(User $user, AgencyProfile $agencyProfile): bool
    {
        return (int) $agencyProfile->user_id === (int) $user->id;
    }
}

