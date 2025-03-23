<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function portfolio() : BelongsTo
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id', 'id');
    }
}
