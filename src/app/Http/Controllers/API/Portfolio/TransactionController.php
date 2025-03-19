<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Models\Portfolio;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Actions\StoreTransactionAction;
use App\Actions\UpdateTransactionAction;
use App\Http\Requests\Portfolio\TransactionRequest;
use App\Http\Resources\Portfolio\TransactionResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\BaseControllers\ServiceController;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TransactionController extends ServiceController
{
    use AuthorizesRequests;

    public function index(Portfolio $portfolio): AnonymousResourceCollection
    {
        $this->authorize('isOwner', $portfolio);

        return TransactionResource::collection($portfolio->transactions);
    }

    public function show(Transaction $transaction): TransactionResource
    {
        $this->authorize('isOwner', $transaction);
        
        return new TransactionResource($transaction);
    }

    public function store(TransactionRequest $transactionRequest, StoreTransactionAction $storeTransactionAction): JsonResponse
    {
        $transactionData = $transactionRequest->validated();

        $responce = $storeTransactionAction->handle($transactionData, $this->coinGeckoService);

        return $responce;
    }

    public function update(TransactionRequest $transactionRequest, Transaction $transaction, UpdateTransactionAction $updateTransactionAction): JsonResponse
    {
        $this->authorize('isOwner', $transaction);

        $transactionData = $transactionRequest->validated();

        $responce = $updateTransactionAction->handle($transactionData, $transaction, $this->coinGeckoService);

        return $responce;
    }


    public function delete(Transaction $transaction) : JsonResponse
    {
        $this->authorize('isOwner', $transaction);

        $transaction->deleteOrFail();

        return response()->json([
            'message' => 'success'
        ], 200);
    }
}
