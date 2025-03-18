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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
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
