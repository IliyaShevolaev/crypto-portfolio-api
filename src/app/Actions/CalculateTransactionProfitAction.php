<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use App\Models\Transaction;
use Brick\Math\RoundingMode;
use Illuminate\Support\Collection;
use App\Contracts\CoinApiInterface;
use App\Http\Resources\Portfolio\TransactionStatsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CalculateTransactionProfitAction
{
    public function handle(Collection $transactions, CoinApiInterface $coinApi): array
    {
        $coinsToRequest = $transactions->pluck('coin_name')->unique()->toArray();
        $currentCoinPrices = $coinApi->getCurrentPrice($coinsToRequest);

        $result = [];

        foreach ($transactions as $transaction) {
            $currentCoinPrice = $currentCoinPrices[$transaction->coin_name]['usd'];
            $transactionPrice = $transaction->price_at_buy_moment;

            $profitValuePercent = BigDecimal::of($currentCoinPrice)->minus(BigDecimal::of($transactionPrice))->dividedBy(BigDecimal::of($transactionPrice), 8, RoundingMode::HALF_UP)->multipliedBy(100);
            $profitSide = $profitValuePercent->toFloat() >= 0 ? '+' : '-';
            $profitValuePrice = BigDecimal::of($currentCoinPrice)->multipliedBy($transaction->amount)->minus($transaction->total_value_in_usd);

            array_push($result, new TransactionStatsResource((object) [
                'profitValuePercent' => abs($profitValuePercent->toFloat()),
                'profitValuePrice' => abs($profitValuePrice->toFloat()),
                'profitSide' => $profitSide,
            ]));
        }

        return $result;
    }
}
