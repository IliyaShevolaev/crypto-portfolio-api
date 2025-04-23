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
     *     security={{"Sanctum Auth":{}}},
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

    public function get(Portfolio $portfolio)
    {
        // 
    }
}
