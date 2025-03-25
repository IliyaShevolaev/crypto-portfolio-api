<?php 

namespace App\Actions;

use Brick\Math\BigDecimal;
use App\Models\Transaction;
use Brick\Math\RoundingMode;
use App\Contracts\CoinApiInterface;
use App\Http\Resources\Portfolio\TransactionStatsResource;

class CalculateTransactionProfitAction
{
    public function handle(Transaction $transaction, CoinApiInterface $coinApi) : TransactionStatsResource
    {
        $currentCoinPrice = $coinApi->getCurrentPrice([$transaction->coin_name])[$transaction->coin_name]['usd'];
        $transactionPrice = $transaction->price_at_buy_moment;

        $profitValuePercent = BigDecimal::of($currentCoinPrice)->minus(BigDecimal::of($transactionPrice))->dividedBy(BigDecimal::of($transactionPrice), 8, RoundingMode::HALF_UP)->multipliedBy(100);

        $profitSide = $profitValuePercent->toFloat() >= 0 ? '+' : '-';

        $profitValuePrice = BigDecimal::of($currentCoinPrice)->multipliedBy($transaction->amount)->minus($transaction->total_value_in_usd);

        return new TransactionStatsResource((object) [
            'profitValuePercent' => abs($profitValuePercent->toFloat()),
            'profitValuePrice' => abs($profitValuePrice->toFloat()),
            'profitSide' => $profitSide,
        ]);
    }
}