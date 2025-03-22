<?php

namespace App\Contracts;

interface CoinApiInterface
{
    public function getCurrentPrice(array $symbol);
    public function getHistoricalPrice(string $symbol, string $date);
}