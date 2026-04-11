<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientSearchService
{
    public function __construct(
        protected ClientReputationService $reputationService
    ) {
    }

    public function search(?string $term, int $perPage = 15): LengthAwarePaginator
    {
        $query = Client::query()->orderBy('name');

        if ($term !== null && $term !== '') {
            $query->where('name', 'like', '%' . trim($term) . '%');
        }

        $this->reputationService->withSummaryMetrics($query);

        return $query->paginate($perPage)->withQueryString();
    }
}

