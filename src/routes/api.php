<?php

use App\Services\CoinmarketcapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {
    return 'test';
});

Route::get('/price-test', function (CoinmarketcapService $coinmarketcap) {
    return $coinmarketcap->getPrice("BTC");
});
