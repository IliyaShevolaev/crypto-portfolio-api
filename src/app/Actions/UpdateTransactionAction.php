<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use App\Services\CoinGeckoService;
use App\Utilities\DateConvertation;
use App\Http\Resources\Portfolio\TransactionResource;
use App\Models\Transaction;

class UpdateTransactionAction
{
    public function handle(array $transactionData, Transaction $transaction, CoinGeckoService $coinGeckoService)
    {
        if (isset($transactionData['transaction_date'])) {
            $currentPrice = $coinGeckoService->getHistoricalPrice(
                $transactionData['coin_name'],
                $transactionData['transaction_date'],
            );
        } else {
            $currentPrice = $coinGeckoService->getCurrentPrice($transactionData['coin_name']);
        }

        if ($currentPrice === null) {
            return response()->json(['error' => 'coin error'], 400);
        }

        $transaction->update([
            'coin_name' => $transactionData['coin_name'],
            'description' => $transactionData['description'] ?? null,
            'amount' => $transactionData['amount'],
            'price_at_buy_moment' => $currentPrice,
            'total_value_in_usd' => BigDecimal::of($currentPrice)->multipliedBy($transactionData['amount']),
            'is_buying' => $transactionData['is_buying'],
            'portfolio_id' => $transactionData['portfolio_id'],
            'transaction_date' => isset($transactionData['transaction_date'])
                ? DateConvertation::dayMonthConvert($transactionData['transaction_date'])
                : now(),
        ]);

        return response()->json(new TransactionResource($transaction), 200);
    }
}