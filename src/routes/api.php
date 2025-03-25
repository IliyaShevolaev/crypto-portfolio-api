<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\CoinmarketcapService;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Portfolio\PortfolioController;
use App\Http\Controllers\API\Portfolio\StatsController;
use App\Http\Controllers\API\Portfolio\TransactionController;
use App\Http\Controllers\API\Portfolio\TransactionStatsController;
use App\Models\Transaction;
use App\Services\CoinGeckoService;

Route::get('/test', function (Request $request, CoinGeckoService $coin) {
    return $coin->getCurrentPrice(['ethereum', 'solana']);
});

Route::get('/user', function (Request $request) {
    return Auth::user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'auth'], function() {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/absolute-logout', [LoginController::class, 'absoluteLogOut'])->middleware('auth:sanctum');
});

Route::group(['prefix' => 'portfolio', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/index', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/show/{portfolio}', [PortfolioController::class, 'show']);
    Route::post('/store', [PortfolioController::class, 'store']);
    Route::patch('/update/{portfolio}', [PortfolioController::class, 'update']);
    Route::delete('/delete/{portfolio}', [PortfolioController::class, 'delete']);
});

Route::group(['prefix' => 'transaction', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/index/{portfolio}', [TransactionController::class, 'index']);
    Route::get('/show/{transaction}', [TransactionController::class, 'show']);
    Route::post('/store', [TransactionController::class, 'store']);
    Route::patch('/update/{transaction}', [TransactionController::class, 'update']);
    Route::delete('/delete/{transaction}', [TransactionController::class, 'delete']);
});

Route::group(['prefix' => 'stats', 'middleware' => 'auth:sanctum'], function() {
    Route::group(['prefix' => 'transaction'], function() {
        Route::get('/index/{portfolio}', [TransactionStatsController::class, 'index']);
        Route::get('/get/{transaction}', [TransactionStatsController::class, 'get']);
    });
});

Route::get('/price-test', function (CoinmarketcapService $coinmarketcap) {
    return $coinmarketcap->getPrice("BTC");
});
