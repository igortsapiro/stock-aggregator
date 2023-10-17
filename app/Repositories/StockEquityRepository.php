<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\StockEquity;
use App\Services\Common\Cache\AggregatorCacheService;

class StockEquityRepository
{
    public function __construct(private readonly AggregatorCacheService $cacheService)
    {
    }

    public function store(array $data): StockEquity
    {
        $model = StockEquity::create($data);
        $this->cacheService->setLatestStock($model);

        return $model;
    }

    public function getLatestBySymbol(string $symbol): ?StockEquity
    {
        $model = $this->cacheService->getLatestStock($symbol);
        if (is_null($model)) {
            $model = StockEquity::query()
                ->where('symbol', $symbol)
                ->latest('refreshed_at')
                ->first();
        }

        return $model;
    }
}
