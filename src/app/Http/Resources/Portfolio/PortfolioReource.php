<?php

namespace App\Http\Resources\Portfolio;

use App\Contracts\CoinApiInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioReource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="PortfolioResource",
     *     type="object",
     *     @OA\Property(property="id", type="integer", description="ID of the portfolio"),
     *     @OA\Property(property="name", type="string", description="Name of the portfolio"),
     *     @OA\Property(property="balance", type="number", format="decimal", description="Portfolio balance in USD as calculated from transactions"),
     *     @OA\Property(property="created_at", type="string", format="date-time", description="Portfolio creation time"),
     *     @OA\Property(property="updated", type="string", format="date-time", description="Portfolio last update time")
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'balance' => $this->balanceCalculate(app(CoinApiInterface::class)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
