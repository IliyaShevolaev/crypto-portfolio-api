<?php

namespace App\Http\Requests\Portfolio;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @OA\Schema(
     *     schema="TransactionRequest",
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
    public function rules(): array
    {
        return [
            'coin_name' => 'required|string|max:30',
            'description' => 'string|max:255',
            'amount' => 'required|numeric|min:0.000000000001',
            'is_buying' => 'required|boolean',
            'portfolio_id' => 'required|integer',
            'transaction_date' => 'nullable|date', //format dd-mm-yy
        ];
    }
}
