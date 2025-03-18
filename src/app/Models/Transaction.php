<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $guarded = false;

    public function portfolio() : BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'id', 'portfolio_id');
    }
}
