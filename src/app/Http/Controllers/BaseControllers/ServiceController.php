<?php

namespace App\Http\Controllers\BaseControllers;

use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected CoinApiInterface $coinApi;

    public function __construct(CoinApiInterface $coinApi)
    {
        $this->coinApi = $coinApi;
    }
}
