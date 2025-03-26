<?php

namespace App\Http\Controllers\Swagger;

use App\Models\Portfolio;
use App\Models\Transaction;
use App\Contracts\CoinApiInterface;
use App\Http\Controllers\Controller;
use App\Actions\CalculateTransactionProfitAction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Tag(
 *     name="Transaction Stats",
 *     description="Operations related to transaction profit and loss statistics"
 * )
 */
class TransactionStatsController extends Controller
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *     path="/api/stats/transaction/index/{portfolio}",
     *     summary="Get transaction statistics for a portfolio",
     *     description="Retrieve profit and loss statistics for all transactions in a given portfolio",
     *     tags={"Transaction Stats"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Parameter(
     *         name="portfolio",
     *         in="path",
     *         required=true,
     *         description="ID of the portfolio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of transaction statistics",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="profitValuePercent", type="number", format="float", description="Percentage of profit/loss"),
     *                 @OA\Property(property="profitValuePrice", type="number", format="float", description="Absolute profit/loss value in USD"),
     *                 @OA\Property(property="profitSide", type="string", description="Price change direction (+/-)", enum={"+", "-"})
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Insufficient rights to access the portfolio"
     *     )
     * )
     */
    public function index(Portfolio $portfolio, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction)
    {
        //
    }

     /**
     * @OA\Get(
     *     path="/api/stats/transaction/get/{transaction}",
     *     summary="Get statistics for a specific transaction",
     *     description="Retrieve profit and loss statistics for a single transaction",
     *     tags={"Transaction Stats"},
     *     security={{"Sanctum Auth":{}}},
     *     @OA\Parameter(
     *         name="transaction",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction statistics",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="profitValuePercent", type="number", format="float", description="Percentage of profit/loss"),
     *             @OA\Property(property="profitValuePrice", type="number", format="float", description="Absolute profit/loss value in USD"),
     *             @OA\Property(property="profitSide", type="string", description="Price change direction (+/-)", enum={"+", "-"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized access"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Insufficient rights to access the transaction"
     *     )
     * )
     */
    public function get(Transaction $transaction, CoinApiInterface $coinApi, CalculateTransactionProfitAction $calculateTransactionProfitAction)
    {
        //
    }
}
