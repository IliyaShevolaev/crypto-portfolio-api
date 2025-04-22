<?php

namespace App\Http\Controllers\BaseControllers;

use App\Http\Controllers\BaseControllers\ServiceController;
use App\Actions\CalculatePortfolioProfitAction;
use App\Actions\CalculateTransactionProfitAction;
use App\Actions\CalculateUserProfitAction;
use App\Contracts\CoinApiInterface;

class StatsController extends ServiceController
{
    protected CalculateTransactionProfitAction $calculateTransactionProfitAction;
    protected CalculatePortfolioProfitAction $calculatePortfolioProfitAction;
    protected CalculateUserProfitAction $calculateUserProfitAction;

    public function __construct(
        CalculateTransactionProfitAction $calculateTransactionProfitAction,
        CalculatePortfolioProfitAction $calculatePortfolioProfitAction,
        CalculateUserProfitAction $calculateUserProfitAction,
        CoinApiInterface $coinApiInterface
    ) {
        parent::__construct($coinApiInterface);
        $this->calculateTransactionProfitAction = $calculateTransactionProfitAction;
        $this->calculatePortfolioProfitAction = $calculatePortfolioProfitAction;
        $this->calculateUserProfitAction = $calculateUserProfitAction;
    }
}
