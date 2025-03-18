<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="Transaction",
     *     type="object",
     *     @OA\Property(property="coin_name", type="string", description="Name of the cryptocurrency involved in the transaction"),
     *     @OA\Property(property="description", type="string", description="A description of the transaction"),
     *     @OA\Property(property="amount", type="number", format="float", description="Amount of the cryptocurrency involved in the transaction"),
     *     @OA\Property(property="price_at_buy_moment", type="number", format="float", description="Price of the cryptocurrency at the moment of the transaction"),
     *     @OA\Property(property="total_value_in_usd", type="number", format="float", description="Total value of the transaction in USD"),
     *     @OA\Property(property="is_buying", type="boolean", description="Indicates whether the transaction is a buy (true) or sell (false)"),
     *     @OA\Property(property="portfolio_id", type="integer", description="ID of the portfolio associated with the transaction"),
     *     @OA\Property(property="transaction_date", type="string", format="date-time", description="Date and time when the transaction occurred")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'coin_name' => $this->coin_name,
            'description' => $this->description,
            'amount' => $this->amount,
            'price_at_buy_moment' => $this->price_at_buy_moment,
            'total_value_in_usd' => $this->total_value_in_usd,
            'is_buying' => $this->is_buying,
            'portfolio_id' => $this->portfolio_id,
            'transaction_date' => $this->transaction_date,
        ];
    }
}
