<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Illuminate\Support\Collection;
use App\Contracts\CoinApiInterface;
use Illuminate\Support\Facades\Cache;

class CalculateTransactionProfitAction
{
    public function handle(Collection $transactions, CoinApiInterface $coinApi): array
    {
        $result = [];

        $transcationsToRequest = [];
        foreach ($transactions as $transaction) {
            $statsCached = Cache::get('transaction_stats:' . $transaction->id);
            if (isset($statsCached)) {
                $result[$transaction->id] = $statsCached;
            } else {
                array_push($transcationsToRequest, $transaction);
            }
        }

        if (!empty($transcationsToRequest)) {
            $coinsToRequest = collect($transcationsToRequest)->pluck('coin_name')->unique()->toArray();
            $currentCoinPrices = $coinApi->getCurrentPrice($coinsToRequest);

            foreach ($transcationsToRequest as $transaction) {
                $currentCoinPrice = $currentCoinPrices[$transaction->coin_name]['usd'];
                $transactionPrice = $transaction->price_at_buy_moment;

                $profitValuePercent = BigDecimal::of($currentCoinPrice)->minus(BigDecimal::of($transactionPrice))->dividedBy(BigDecimal::of($transactionPrice), 8, RoundingMode::HALF_UP)->multipliedBy(100);

                $profitSide = $profitValuePercent->toFloat() >= 0 ? '+' : '-';

                $profitValuePrice = BigDecimal::of($currentCoinPrice)->multipliedBy($transaction->amount)->minus($transaction->total_value_in_usd);

                $currentStats = [
                    'profitValuePercent' => abs($profitValuePercent->toFloat()),
                    'profitValuePrice' => abs($profitValuePrice->toFloat()),
                    'profitSide' => $profitSide,
                ];

                $result[$transaction->id] = $currentStats;
                
                Cache::put(
                    'transaction_stats:' . $transaction->id,
                    $currentStats, 
                    config('cached-values-time.transactions_stats')
                );
            }
        }

        return $result;
    }
}
