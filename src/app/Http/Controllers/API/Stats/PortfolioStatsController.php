<?php

namespace App\Http\Controllers\API\Stats;

use App\Models\Portfolio;
use App\Http\Controllers\BaseControllers\StatsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PortfolioStatsController extends StatsController
{
    use AuthorizesRequests;

    public function index() : JsonResponse
    {
        $userStats = $this->calculateUserProfitAction->handle(
            $this->calculateTransactionProfitAction,
            $this->calculatePortfolioProfitAction,
            $this->coinApi,
        );

        return response()->json([
            $userStats
        ], 200);
    }

    public function get(Portfolio $portfolio): JsonResponse
    {
        $this->authorize('isOwner', $portfolio);

        $transactions = $portfolio->transactions;
        $transactionsStats = $this->calculateTransactionProfitAction->handle($transactions, $this->coinApi);

        $totalPortfolioStats = $this->calculatePortfolioProfitAction->handle($transactions, $transactionsStats);

        return response()->json([
            'totalStats' => $totalPortfolioStats,
            'transactionStats' => $transactionsStats
        ], 200);
    }
}
