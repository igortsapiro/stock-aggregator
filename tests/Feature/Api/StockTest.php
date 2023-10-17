<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\StockEquity;
use Tests\TestCase;

class StockTest extends TestCase
{
    public function testGetLatest(): void
    {
        $model = StockEquity::factory()->create();

        $response = $this->get('/api/stocks/latest/' . $model->symbol);

        $response->assertOk();
        $response->assertJsonFragment($model->toArray());
    }

    public function testGetReports(): void
    {
        $enabledStocks = config('stock-aggregator.enabled_stocks');
        $expectedData = [];
        foreach ($enabledStocks as $enabledStock) {
            $model = StockEquity::factory()->create(['symbol' => $enabledStock]);
            $expectedData[$enabledStock] = $model->percentage_stage;
        }

        $response = $this->json('get', '/api/stocks/reports', [
            'symbols' => $enabledStocks
        ]);

        $response->assertOk();
        $response->assertJsonFragment($expectedData);
    }
}
