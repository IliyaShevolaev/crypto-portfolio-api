<?php

namespace App\Http\Controllers\API\Stats;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PortfolioStatsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {

    }

    public function get(Portfolio $portfolio, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction) : JsonResponse
    {
        $this->authorize('isOwner', $portfolio);

        $transactions = $portfolio->transactions;
        $transactionsStats = $calculateTransactionProfitAction->handle($transactions, $coinApi);

        return response()->json($transactionsStats, 200);
    }
}
