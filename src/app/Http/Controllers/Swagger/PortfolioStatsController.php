<?php

namespace App\Http\Controllers\Swagger;

use App\Models\Portfolio;
use App\Http\Controllers\BaseControllers\StatsController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class PortfolioStatsController extends StatsController
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/stats/portfolio/index",
     *     summary="Get statistics for all user portfolios",
     *     description="Returns overall profit statistics for all user portfolios, including total user profit and individual portfolio stats.",
     *     tags={"Portfolio Stats"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="User and portfolios statistics",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="userAccountStats", type="object",
     *                 @OA\Property(property="totalProfitPrice", type="number", format="float", example=125.35, description="Total profit or loss in USD"),
     *                 @OA\Property(property="totalProfitPercent", type="number", format="float", example=14.27, description="Total profit or loss in percentage"),
     *                 @OA\Property(property="profitSide", type="string", example="+", enum={"+", "-"}, description="Profit side: '+' for gain, '-' for loss")
     *             ),
     *             @OA\Property(
     *                 property="porftoliosStats",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="balanceStartValue", type="number", format="float", example=1000.0),
     *                     @OA\Property(property="balanceCurrentValue", type="number", format="float", example=1125.35),
     *                     @OA\Property(property="profitValuePercent", type="number", format="float", example=12.53),
     *                     @OA\Property(property="profitValuePrice", type="number", format="float", example=125.35),
     *                     @OA\Property(property="profitSide", type="string", example="+", enum={"+", "-"})
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     * 
     * )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/stats/portfolio/get/{id}",
     *     summary="Get statistics for single user portfolio",
     *     description="Returns profit statistics for single user portfolios, including portfolio profit and individual transactions stats.",
     *     tags={"Portfolio Stats"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Portfolio ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Portfolio statistics with transactions",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="totalStats",
     *                 type="object",
     *                 @OA\Property(property="balanceStartValue", type="number", format="float", example=391890.39, description="Initial portfolio balance value"),
     *                 @OA\Property(property="balanceCurrentValue", type="number", format="float", example=509325.45, description="Current portfolio balance value"),
     *                 @OA\Property(property="profitValuePercent", type="number", format="float", example=29.96, description="Profit percentage"),
     *                 @OA\Property(property="profitValuePrice", type="number", format="float", example=117435.05, description="Profit value in currency"),
     *                 @OA\Property(property="profitSide", type="string", example="+", enum={"+", "-"}, description="Profit direction: '+' for gain, '-' for loss")
     *             ),
     *             @OA\Property(
     *                 property="transactionStats",
     *                 type="object",
     *                 description="Statistics for individual transactions, keyed by transaction ID",
     *                 @OA\AdditionalProperties(
     *                     type="object",
     *                     @OA\Property(property="profitValuePercent", type="number", format="float", example=14.59, description="Transaction profit percentage"),
     *                     @OA\Property(property="profitValuePrice", type="number", format="float", example=14.83, description="Transaction profit value in currency"),
     *                     @OA\Property(property="profitSide", type="string", example="+", enum={"+", "-"}, description="Transaction profit direction: '+' for gain, '-' for loss")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Forbidden"
     *     )
     * )
     */
    public function get(Portfolio $portfolio)
    {
        //
    }
}
