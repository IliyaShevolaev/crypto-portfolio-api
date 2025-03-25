<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use Brick\Math\BigDecimal;
use App\Models\Transaction;
use Brick\Math\RoundingMode;
use Illuminate\Http\JsonResponse;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\Portfolio\TransactionStatsResource;

class TransactionStatsController extends Controller
{
    use AuthorizesRequests;

    public function index(Portfolio $portfolio, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction)
    {
        $transactions = $portfolio->transactions;
        $transactionsStats = [];

        foreach($transactions as $transaction) { // TO DO: API call optimize
            array_push($transactionsStats, $calculateTransactionProfitAction->handle($transaction, $coinApi));
        }

        return TransactionStatsResource::collection($transactionsStats);
    }


    public function get(Transaction $transaction, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : TransactionStatsResource
    {
        $this->authorize('isOwner', $transaction);

        $resource = $calculateTransactionProfitAction->handle($transaction, $coinApi);
        
        return $resource;
    }
}
