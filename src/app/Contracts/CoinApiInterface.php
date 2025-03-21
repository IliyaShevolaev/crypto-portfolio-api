<?php

namespace App\Contracts;

interface CoinApiInterface
{
    public function getCurrentPrice(string $symbol, string $currency = 'usd');
    public function getHistoricalPrice(string $symbol, string $date, string $currency = 'usd');
}