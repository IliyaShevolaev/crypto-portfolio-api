<?php

namespace App\Actions;

use App\Contracts\CoinApiInterface;
use App\Models\Portfolio;
use App\Services\CoinGeckoService;
use Brick\Math\BigDecimal;

class PortfolioBalanceCalculateAction
{
    public static function calculate(Portfolio $portfolio, CoinApiInterface $coinApi) : BigDecimal
    {
        $balance = BigDecimal::of('0.0');

        foreach ($portfolio->transactions as $transaction) {
            if ($transaction->is_buying) {
                $balance = $balance->plus(BigDecimal::of($transaction->total_value_in_usd));
            } else {
                $balance = $balance->minus(BigDecimal::of($transaction->total_value_in_usd));
            }
        } 

        return $balance;
    }
}