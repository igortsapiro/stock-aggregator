<?php

use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.')
    ->group(function () {
        Route::get('/stocks/latest/{symbol}', [StockController::class, 'getLatest'])->name('stocks.latest');
        Route::get('/stocks/reports', [StockController::class, 'getReports'])
            ->name('stocks.latest');
    });
