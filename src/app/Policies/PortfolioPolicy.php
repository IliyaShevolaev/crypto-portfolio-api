<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PortfolioPolicy
{
    public function isowner(User $user, Portfolio $portfolio): bool
    {
        return $user->id == $portfolio->user_id;
    }
}
