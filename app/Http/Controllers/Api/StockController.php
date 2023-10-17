<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetReportsRequest;
use App\Services\Api\StockService;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    public function __construct(private readonly StockService $stockService)
    {
    }

    public function getLatest(string $symbol): JsonResponse
    {
        $result = $this->stockService->getLatest($symbol);

        return response()->json($result);
    }

    public function getReports(GetReportsRequest $request): JsonResponse
    {
        $result = $this->stockService->getReports($request->symbols);

        return response()->json($result);
    }
}
