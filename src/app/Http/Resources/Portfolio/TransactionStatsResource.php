<?php

namespace App\Http\Resources\Portfolio;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'valuePercent' => $this->profitValuePercent,
            'valuePrice' => $this->profitValuePrice,
            'sign' => $this->profitSide,
        ];
    }
}
