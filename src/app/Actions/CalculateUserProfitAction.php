<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use App\Contracts\CoinApiInterface;
use Illuminate\Support\Facades\Auth;

class CalculateUserProfitAction
{
    public function handle(
        CalculateTransactionProfitAction $calculateTransactionProfitAction,
        CalculatePortfolioProfitAction $calculatePortfolioProfitAction,
        CoinApiInterface $coinApi) : array
    {
        $startValue = BigDecimal::zero();
        $finallyValue = BigDecimal::zero();

        $portfolios = Auth::user()->portfolios()->with('transactions')->get();

        $totalPortfolioStats = [];

        foreach ($portfolios as $portfolio) {
            $transactionsStats = $calculateTransactionProfitAction->handle($portfolio->transactions, $coinApi);

            $totalPortfolioResults = $calculatePortfolioProfitAction->handle($portfolio->transactions, $transactionsStats);
            array_push($totalPortfolioStats, $totalPortfolioResults);

            $startValue = $startValue->plus(BigDecimal::of($totalPortfolioResults['balanceStartValue']));
            $finallyValue = $finallyValue->plus(BigDecimal::of($totalPortfolioResults['balanceCurrentValue']));
        }

        $profitPrice = $finallyValue->minus($startValue);
        $profitPrice->toFloat() >= 0 ? $profitSide = '+' : $profitSide = '-';

        if ($profitPrice->isZero()) {
            $profitPercent = BigDecimal::of(0);
        } else {
            $profitPercent = $finallyValue->minus($startValue)->abs()->dividedBy($startValue, 8, RoundingMode::HALF_UP)->multipliedBy(100);
        }

        $totalUserAccountStats = [
            'totalProfitPrice' => $profitPrice->abs()->toFloat(),
            'totalProfitPercent' => $profitPercent->toFloat(),
            'profitSide' => $profitSide,
        ];

        return [
            'userAccountStats' => $totalUserAccountStats,
            'porftoliosStats' => $totalPortfolioStats,
        ];
    }
}
