<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use App\Models\Transaction;
use Brick\Math\RoundingMode;
use App\Contracts\CoinApiInterface;
use App\Utilities\DateConvertation;
use App\Http\Resources\Portfolio\TransactionResource;

class UpdateTransactionAction
{
    public function handle(array $transactionData, Transaction $transaction, CoinApiInterface $coinApi)
    {
        if (isset($transactionData['amount']) && isset($transactionData['total_value_in_usd'])) {
            return response()->json(['error' => 'wrong request'], 422);
        }

        $coinName = $transactionData['coin_name'];

        if (isset($transactionData['transaction_date'])) {
            $currentPrice = $coinApi->getHistoricalPrice(
                $coinName, 
                $transactionData['transaction_date'],
            );
        } else {
            $currentPrice = $coinApi->getCurrentPrice([$coinName])[$coinName]['usd'];
        }

        if ($currentPrice === null) {
            return response()->json(['error' => 'coin error'], 400);
        }

        if (isset($transactionData['total_value_in_usd'])) {
            $totalValueInUsd = $transactionData['total_value_in_usd'];
            $amount = BigDecimal::of($totalValueInUsd)->dividedBy(BigDecimal::of($currentPrice), 8, RoundingMode::HALF_UP);
        } else {
            $amount = $transactionData['amount'];
            $totalValueInUsd = BigDecimal::of($currentPrice)->multipliedBy(BigDecimal::of($amount));
        }

        $transaction = Transaction::update([
            'coin_name' => $coinName,
            'description' => $transactionData['description'] ?? null,
            'amount' => $amount,
            'price_at_buy_moment' => $currentPrice,
            'total_value_in_usd' => $totalValueInUsd,
            'is_buying' => $transactionData['is_buying'],
            'portfolio_id' => $transactionData['portfolio_id'],
            'transaction_date' => isset($transactionData['transaction_date']) ? DateConvertation::dayMonthConvert($transactionData['transaction_date']) : now(),
        ]);

        return response()->json(new TransactionResource($transaction), 200);
    }
}