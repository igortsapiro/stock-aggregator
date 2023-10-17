<?php

declare(strict_types=1);

namespace App\Services\External\Aggregator;

use App\Exceptions\AggregatorException;
use Throwable;

class AggregatorService
{
    private const FUNCTION_INTRADAY = 'TIME_SERIES_INTRADAY';

    public function __construct(private readonly HttpClient $httpClient)
    {
    }

    public function getIntradayStockData(string $symbol, TimeInterval $interval = TimeInterval::ONE_MINUTE): array
    {
        $params = [
            'function' => self::FUNCTION_INTRADAY,
            'symbol' => $symbol,
            'interval' => $interval->value
        ];
        try {
            $result = json_decode($this->httpClient->makeGetRequest($params), true);

            if (count($result) === 1 && array_key_exists('Note', $result)) {
                throw new AggregatorException($result['Note']);
            }

            return $result['Time Series (' . $interval->value . ')'];
        } catch (Throwable $exception) {
            report($exception);

            return [];
        }
    }
}
