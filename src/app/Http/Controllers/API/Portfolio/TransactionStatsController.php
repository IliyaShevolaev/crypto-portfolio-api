<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use App\Models\Transaction;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class TransactionStatsController extends Controller
{
    use AuthorizesRequests;

    public function index(Portfolio $portfolio, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : JsonResponse
    {
        $transactions = $portfolio->transactions;
        $transactionsStats = $calculateTransactionProfitAction->handle($transactions, $coinApi);

        return response()->json($transactionsStats, 200);
    }

    public function get(Transaction $transaction, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : JsonResponse
    {
        $this->authorize('isOwner', $transaction);

        $stats = $calculateTransactionProfitAction->handle(collect([$transaction]), $coinApi);
        
        return response()->json($stats[0], 200);
    }
}
