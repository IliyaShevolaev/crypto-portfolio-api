<?php

namespace App\Http\Controllers\API\Stats;

use App\Models\Transaction;
use App\Http\Controllers\BaseControllers\StatsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class TransactionStatsController extends StatsController
{
    use AuthorizesRequests;

    public function get(Transaction $transaction) : JsonResponse
    {
        $this->authorize('isOwner', $transaction);

        $result = $this->calculateTransactionProfitAction->handle(collect([$transaction]), $this->coinApi);

        return response()->json($result[0], 200);
    }
}
