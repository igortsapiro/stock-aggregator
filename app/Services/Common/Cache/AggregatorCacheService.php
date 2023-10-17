<?php

declare(strict_types=1);

namespace App\Services\Common\Cache;

use App\Models\StockEquity;
use Illuminate\Support\Facades\Cache;

class AggregatorCacheService
{
    private const TTL_ONE_MONTH = 2592000; // 30 days

    public function setLatestStock(StockEquity $stockEquity): void
    {
        $key = 'latest-stock-price:' . $stockEquity->symbol;
        Cache::put($key, json_encode($stockEquity), self::TTL_ONE_MONTH);
    }

    public function getLatestStock(string $symbol): ?StockEquity
    {
        return Cache::get('latest-stock-price:' . $symbol);
    }
}
