<?php

namespace App\Http\Controllers\API\Stats;

use App\Models\Transaction;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class TransactionStatsController extends Controller
{
    use AuthorizesRequests;

    public function get(Transaction $transaction, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : JsonResponse
    {
        $this->authorize('isOwner', $transaction);

        $result = $calculateTransactionProfitAction->handle(collect([$transaction]), $coinApi);

        return response()->json($result[0], 200);
    }
}
