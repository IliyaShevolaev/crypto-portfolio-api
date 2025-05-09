<?php

namespace App\Http\Controllers\Swagger;

use App\Actions\StoreTransactionAction;
use App\Actions\UpdateTransactionAction;
use App\Http\Controllers\BaseControllers\ServiceController;
use App\Http\Requests\Portfolio\TransactionRequest;
use App\Models\Portfolio;
use App\Models\Transaction;

/**
 * @OA\Tag(
 *     name="Transaction",
 *     description="Operations related to portfolio transactions"
 * )
 */

class TransactionController extends ServiceController
{
    /**
     * @OA\Get(
     *     path="/api/transaction/index/{portfolio}",
     *     summary="Get portfolio transactions",
     *     description="Retrieve a list of transactions for a given portfolio",
     *     tags={"Transaction"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="portfolio",
     *         in="path",
     *         required=true,
     *         description="ID of the portfolio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of transactions",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Transaction"))
     *     )
     * )
     */
    public function index(Portfolio $portfolio)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/transaction/show/{transaction}",
     *     summary="Get transaction details",
     *     description="Retrieve details of a specific transaction",
     *     tags={"Transaction"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="transaction",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction details",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     )
     * )
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/transaction/store",
     *     summary="Create a new transaction",
     *     description="Add a new transaction to the portfolio",
     *     tags={"Transaction"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TransactionRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Transaction")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(TransactionRequest $transactionRequest, StoreTransactionAction $storeTransactionAction)
    {
        //
    }

    /**
     * @OA\Patch(
     *     path="/api/transaction/update/{transaction}",
     *     summary="Update a transaction",
     *     description="Modify an existing transaction",
     *     tags={"Transaction"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="transaction",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TransactionRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(TransactionRequest $transactionRequest, Transaction $transaction, UpdateTransactionAction $updateTransactionAction)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/transaction/delete/{transaction}",
     *     summary="Delete a transaction",
     *     description="Remove a specific transaction from the portfolio",
     *     tags={"Transaction"},
     *     security={{"SanctumAuth":{}}},
     *     @OA\Parameter(
     *         name="transaction",
     *         in="path",
     *         required=true,
     *         description="ID of the transaction to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Transaction not found"
     *     )
     * )
     */
    public function delete(Transaction $transaction)
    {
        //
    }
}
