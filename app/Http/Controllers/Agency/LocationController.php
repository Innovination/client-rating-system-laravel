<?php

namespace App\Http\Controllers\Agency;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function states(Request $request): JsonResponse
    {
        $states = State::where('country_id', $request->country_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    public function cities(Request $request): JsonResponse
    {
        $cities = City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }
}
