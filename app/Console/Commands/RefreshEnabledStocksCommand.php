<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\StockEquity;
use App\Repositories\StockEquityRepository;
use App\Services\External\Aggregator\AggregatorService;
use Illuminate\Console\Command;

class RefreshEnabledStocksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-enabled-stocks-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh intraday 1 minute enabled stocks';

    public function __construct(
        private readonly AggregatorService $aggregatorService,
        private readonly StockEquityRepository $stockEquityRepository
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // in free version we can make only 5 calls per minute. There is also limit 100 calls per day
        $enabledStocks = config('stock-aggregator.enabled_stocks');
        foreach ($enabledStocks as $enabledStock) {
            $result = $this->aggregatorService->getIntradayStockData($enabledStock);
            if (!empty($result)) {
                $result = collect($result)->slice(0, 2)->toArray();
                $date = key($result);
                $values = reset($result);
                $lastElement = collect(array_pop($result))->mapWithKeys(function ($value, $key) {
                    return [explode(' ', $key)[1] => $value];
                })->toArray();

                $values = collect($values)->mapWithKeys(function ($value, $key) {
                    return [explode(' ', $key)[1] => $value];
                })->toArray();
                $values['symbol'] = $enabledStock;
                $values['refreshed_at'] = $date;
                $values['percentage_stage'] = round(
                    ($values['close'] - $lastElement['close']) / $lastElement['close'] * 100,
                    2
                );

                $isExists = StockEquity::query()
                    ->where('symbol', $enabledStock)
                    ->where('refreshed_at', $date)
                    ->exists();
                if (!$isExists) {
                    $this->stockEquityRepository->store(array_merge($values, [
                        'symbol' => $enabledStock,
                        'refreshed_at' => $date
                    ]));
                }
            }
        }

        return self::SUCCESS;
    }
}
