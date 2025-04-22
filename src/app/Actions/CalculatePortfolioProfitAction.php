<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Illuminate\Database\Eloquent\Collection;

class CalculatePortfolioProfitAction
{
    public function handle(Collection $transactions, array $transactionsStats): array
    {
        $startValue = BigDecimal::zero();
        $finallyValue = BigDecimal::zero();

        foreach ($transactions as $transaction) {
            $currentTransactionsStats = $transactionsStats[$transaction->id];
            $currentPriceChange = $currentTransactionsStats['profitValuePrice'];
            $isPositiveSide = $currentTransactionsStats['profitSide'] === '+';

            $startValue = $startValue->plus(BigDecimal::of($transaction->total_value_in_usd));

            $finallyValue = $finallyValue->plus(BigDecimal::of($transaction->total_value_in_usd));
            $finallyValue = $isPositiveSide ? $finallyValue->plus(BigDecimal::of($currentPriceChange)) : $finallyValue->minus(BigDecimal::of($currentPriceChange));
        }

        $profitPriceValue = $finallyValue->minus($startValue);

        $profitPriceValue->toFloat() >= 0 ? $profitSide = '+' : $profitSide = '-';

        if ($profitPriceValue->isZero()) {
            $profitValuePercent = BigDecimal::of(0);
        } else {
            $profitValuePercent = $finallyValue->minus($startValue)->abs()->dividedBy($startValue, 8, RoundingMode::HALF_UP)->multipliedBy(100);
        }

        return [
            'balanceStartValue' => $startValue->toFloat(),
            'balanceCurrentValue' => $finallyValue->toFloat(),
            'profitValuePercent' => $profitValuePercent->toFloat(),
            'profitValuePrice' => $profitPriceValue->abs()->toFloat(),
            'profitSide' => $profitSide,
        ];
    }
}
