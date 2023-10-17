<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Models\StockEquity;
use App\Repositories\StockEquityRepository;

class StockService
{
    public function __construct(private readonly StockEquityRepository $stockEquityRepository)
    {
    }

    public function getLatest(string $symbol): array
    {
        /** @var StockEquity|null $result */
        $result = $this->stockEquityRepository->getLatestBySymbol($symbol);

        if (is_null($result)) {
            return [];
        }

        return $result->toArray();
    }

    public function getReports(array $symbols) : array
    {
        return collect($symbols)->mapWithKeys(function ($value) {
            return [$value => $this->stockEquityRepository->getLatestBySymbol($value)?->percentage_stage ?? null];
        })->toArray();
    }
}
