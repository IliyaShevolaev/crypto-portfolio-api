<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    public function isOwner(User $user, Transaction $transaction): bool
    {
        return $user->id == $transaction->portfolio->user_id;
    }
}
