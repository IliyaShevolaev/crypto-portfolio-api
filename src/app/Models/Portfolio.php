<?php

namespace App\Models;

use App\Contracts\CoinApiInterface;
use Brick\Math\BigDecimal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Portfolio extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'portfolio_id', 'id');
    }

    public function balanceCalculate(CoinApiInterface $coinApi) : BigDecimal
    {
        $balance = BigDecimal::of('0.0');
        $coins = $this->transactions->pluck('coin_name')->all();
        $currentCoinPrices = $coinApi->getCurrentPrice($coins);

        foreach ($this->transactions as $transaction) {
            $currentCoinPrice = $currentCoinPrices[$transaction->coin_name]['usd'];

            if ($transaction->is_buying) {
                $balance = $balance->plus(BigDecimal::of($currentCoinPrice)->multipliedBy(BigDecimal::of($transaction->amount)));
            } else {
                $balance = $balance->minus(BigDecimal::of($currentCoinPrice)->multipliedBy(BigDecimal::of($transaction->amount)));
            }            
        } 

        return $balance;
    }
}
