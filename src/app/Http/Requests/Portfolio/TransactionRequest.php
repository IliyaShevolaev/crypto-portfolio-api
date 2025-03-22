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
     *     @OA\Property(property="coin_name", type="string", maxLength=30, description="Name of the cryptocurrency involved in the transaction"),
     *     @OA\Property(property="description", type="string", maxLength=255, description="A description of the transaction", nullable=true),
     *     @OA\Property(property="amount", type="number", format="float", description="Amount of the cryptocurrency involved in the transaction (required if total_value_in_usd is not provided)", nullable=true),
     *     @OA\Property(property="total_value_in_usd", type="number", format="float", description="Total value of the transaction in USD (required if amount is not provided)", nullable=true),
     *     @OA\Property(property="is_buying", type="boolean", description="Indicates whether the transaction is a buy (true) or sell (false)"),
     *     @OA\Property(property="portfolio_id", type="integer", description="ID of the portfolio associated with the transaction"),
     *     @OA\Property(property="transaction_date", type="string", format="date-time", description="Date and time when the transaction occurred (format: dd-mm-yyyy)", nullable=true)
     * )
     */
    public function rules(): array
    {
        return [
            'coin_name' => 'required|string|max:30',
            'description' => 'string|max:255',
            'amount' => 'nullable|required_without:total_value_in_usd|numeric',
            'total_value_in_usd' => 'nullable|required_without:amount|numeric',
            'is_buying' => 'required|boolean',
            'portfolio_id' => 'required|integer',
            'transaction_date' => 'nullable|date', //format dd-mm-yy
        ];
    }
}
