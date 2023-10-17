<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Console\Commands\RefreshEnabledStocksCommand;
use App\Models\StockEquity;
use App\Repositories\StockEquityRepository;
use App\Services\External\Aggregator\AggregatorService;
use Tests\TestCase;

class RefreshEnabledStocksCommandTest extends TestCase
{
    public function testRightHandling(): void
    {
        $repository = app(StockEquityRepository::class);
        $mockedAggregatorService = $this->createMock(AggregatorService::class);
        $mockedAggregatorService->method('getIntradayStockData')
            ->willReturn($this->getMockedData());

        $command = new RefreshEnabledStocksCommand(
            $mockedAggregatorService,
            $repository
        );
        $command->handle();
        $this->assertEquals(count(config('stock-aggregator.enabled_stocks')), StockEquity::query()->count());

        $mockedData = $mockedAggregatorService->getIntradayStockData('test');
        $mockedData = array_reverse($mockedData);
        $first = array_pop($mockedData);
        $second = array_pop($mockedData);
        $expectedPercentage = round(($first['4. close'] - $second['4. close']) / $second['4. close'] * 100, 2);

        $this->assertEquals($expectedPercentage, StockEquity::first()->percentage_stage);
    }

    private function getMockedData(): array
    {
        $result = [];
        $date = now();
        for ($i = 0; $i < 100; $i++) {
            $result[$date->subDays(rand(1, 5))->toDateTimeString()] = [
                '1. open' => fake()->randomFloat(4, 0, 1000),
                '2. high' => fake()->randomFloat(4, 0, 1000),
                '3. low' => fake()->randomFloat(4, 0, 1000),
                '4. close' => fake()->randomFloat(4, 0, 1000),
                '5. volume' => fake()->randomDigit()
            ];
        }

        return $result;
    }
}
