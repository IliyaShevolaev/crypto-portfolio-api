<?php

use App\Http\Controllers\Auth\LoginController;
use App\Services\CoinmarketcapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return 'test';
});

Route::get('/user', function (Request $request) {
    return 'user';
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/price-test', function (CoinmarketcapService $coinmarketcap) {
    return $coinmarketcap->getPrice("BTC");
});
