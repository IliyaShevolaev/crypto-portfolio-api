<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\CoinmarketcapService;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Portfolio\PortfolioController;
use Brick\Math\BigDecimal;

Route::get('/test', function (Request $request) {
    $balance = BigDecimal::of('0.00000001');
    $balance = $balance->plus(BigDecimal::of('0.000002111'));

    return $balance;
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
    Route::get('/index', [PortfolioController::class, 'index']);
    Route::get('/show/{portfolio}', [PortfolioController::class, 'show']);
    Route::post('/store', [PortfolioController::class, 'store']);
    Route::patch('/update/{portfolio}', [PortfolioController::class, 'update']);
    Route::delete('/delete/{portfolio}', [PortfolioController::class, 'delete']);
});

Route::get('/price-test', function (CoinmarketcapService $coinmarketcap) {
    return $coinmarketcap->getPrice("BTC");
});
