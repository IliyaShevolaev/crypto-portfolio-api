<?php

namespace App\Http\Controllers\API\Portfolio;

use App\Actions\StoreTransactionAction;
use App\Http\Controllers\BaseControllers\ServiceController;
use App\Http\Requests\Portfolio\TransactionRequest;
use Illuminate\Http\JsonResponse;

class TransactionController extends ServiceController
{
    public function store(TransactionRequest $transactionRequest, StoreTransactionAction $storeTransactionAction) : JsonResponse
    {
        $transactionData = $transactionRequest->validated();

        $transaction = $storeTransactionAction->handle($transactionData, $this->coinGeckoService);

        return response()->json($transaction, 201);
    }
}
