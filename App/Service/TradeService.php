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

    public function validateBusinessRules(array $data): array
    {
        $errors = [];
        $user = User::find($data['user_id']);
        $stock = $user ? $user->stocks()->find($data['stock_id']) : null;

        $totalPrice = ($stock->price ?? 0) * $data['quantity'];

        if ($user && $data['type'] === 'buy' && $user->balance < $totalPrice) {
            $errors[] = 'Saldo insuficiente para compra.';
        }

        if ($data['type'] === 'sell') {
            $stockId = $data['stock_id'];

            $ownedQty = Trade::where('user_id', $user->id)
                ->where('stock_id', $stockId)
                ->where('type', 'buy')
                ->sum('quantity');

            $soldQty = Trade::where('user_id', $user->id)
                ->where('stock_id', $stockId)
                ->where('type', 'sell')
                ->sum('quantity');

            $availableQty = $ownedQty - $soldQty;

            if ($availableQty <= 0) {
                $errors[] = "Você não possui ações desta empresa para vender.";
            } 
        }
        return $errors;
    }

    public function performTrade(array $data)
    {
        return $this->repository->executeTrade($data);
    }
}
