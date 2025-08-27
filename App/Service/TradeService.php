<?php

namespace App\Service;

use App\Repository\TradeRepository;
use App\Models\User;
use App\Models\Trade;

class TradeService
{
    protected TradeRepository $repository;

    public function __construct(TradeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function performTrade(array $data)
    {
        return $this->repository->executeTrade($data);
    }
}
