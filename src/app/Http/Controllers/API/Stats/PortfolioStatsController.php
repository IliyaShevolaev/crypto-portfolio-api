<?php

namespace App\Http\Controllers\API\Stats;

use App\Actions\CalculatePortfolioProfitAction;
use App\Models\Portfolio;
use App\Contracts\CoinApiInterface;
use App\Actions\CalculateTransactionProfitAction;
use App\Http\Controllers\BaseControllers\ServiceController;
use App\Http\Controllers\BaseControllers\StatsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;   

class PortfolioStatsController extends StatsController
{
    use AuthorizesRequests;

    public function index() {}

    public function get(Portfolio $portfolio): JsonResponse 
    {
        $this->authorize('isOwner', $portfolio);

        $transactions = $portfolio->transactions;
        $transactionsStats = $this->calculateTransactionProfitAction->handle($transactions, $this->coinApi);

        $totalPortfolioResults = $this->calculatePortfolioProfitAction->handle($transactions, $transactionsStats);

        return response()->json([
            'total_value' => 100,
            'transaction_stats' => $transactionsStats
        ], 200);
    }
}
