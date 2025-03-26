<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use App\Models\Transaction;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Resources\Portfolio\TransactionStatsResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionStatsController extends Controller
{
    use AuthorizesRequests;

    public function index(Portfolio $portfolio, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : AnonymousResourceCollection
    {
        $transactions = $portfolio->transactions;
        $transactionsStats = $calculateTransactionProfitAction->handle($transactions, $coinApi);

        return TransactionStatsResource::collection($transactionsStats);
    }

    public function get(Transaction $transaction, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : TransactionStatsResource
    {
        $this->authorize('isOwner', $transaction);

        $resource = $calculateTransactionProfitAction->handle(collect([$transaction]), $coinApi);
        
        return $resource[0];
    }
}
