<?php

declare(strict_types=1);

namespace App\Services\External\Aggregator;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;

class HttpClient
{
    private string $url;
    private string $apiKey;

    public function __construct()
    {
        $this->url = rtrim(config('services.aggregator.url'), '/') . '/query';
        $this->apiKey = config('services.aggregator.key');
    }

    /**
     * @throws HttpClientException
     */
    public function makeGetRequest(array $params): string
    {
        $result = Http::get($this->url, $this->prepareParams($params));

        if ($result->ok()) {
            return $result->body();
        } else {
            throw new HttpClientException($result->body(), $result->status());
        }
    }

    private function prepareParams(array $params): array
    {
        return array_merge($params, [
            'apikey' => $this->apiKey
        ]);
    }
}
