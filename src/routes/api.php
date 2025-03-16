<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\CoinmarketcapService;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;

Route::get('/test', function (Request $request) {
    return 'test';
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

Route::get('/price-test', function (CoinmarketcapService $coinmarketcap) {
    return $coinmarketcap->getPrice("BTC");
});
