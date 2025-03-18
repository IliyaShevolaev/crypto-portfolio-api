<?php

namespace App\Http\Controllers\BaseControllers;

use App\Http\Controllers\Controller;
use App\Services\CoinGeckoService;
use App\Services\CoinmarketcapService;

class ServiceController extends Controller
{
    protected CoinGeckoService $coinGeckoService;

    public function __construct(CoinGeckoService $coinGeckoService)
    {
        $this->coinGeckoService = $coinGeckoService;
    }
}
