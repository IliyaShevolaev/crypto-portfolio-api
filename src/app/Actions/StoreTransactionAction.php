<?php

namespace App\Actions;

use Brick\Math\BigDecimal;
use App\Models\Transaction;
use App\Contracts\CoinApiInterface;
use App\Utilities\DateConvertation;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Portfolio\TransactionResource;

class StoreTransactionAction
{
    public function handle(array $transactionData, CoinApiInterface $coinApi)
    {
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

        $transaction = Transaction::create([
            'coin_name' => $coinName,
            'description' => $transactionData['description'] ?? null,
            'amount' => $transactionData['amount'],
            'price_at_buy_moment' => $currentPrice,
            'total_value_in_usd' => BigDecimal::of($currentPrice)->multipliedBy($transactionData['amount']),
            'is_buying' => $transactionData['is_buying'],
            'portfolio_id' => $transactionData['portfolio_id'],
            'transaction_date' => isset($transactionData['transaction_date']) ? DateConvertation::dayMonthConvert($transactionData['transaction_date']) : now(),
        ]);

        return response()->json(new TransactionResource($transaction), 200);
    }
}