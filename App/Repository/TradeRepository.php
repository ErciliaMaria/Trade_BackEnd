<?php
namespace App\Repository;

use App\Models\Trade;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Database\Capsule\Manager as DB;

class TradeRepository
{
    public function executeTrade(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::find($data['user_id']);
            $stock = Stock::find($data['stock_id']);
            $totalPrice = $stock->price * $data['quantity'];

            if ($data['type'] === 'buy') {
                if (($user->balance - $totalPrice) < 0) {
                    throw new \Exception("Saldo insuficiente para comprar {$data['quantity']} de {$stock->symbol}.");
                }
                $user->balance -= $totalPrice;
                $user->save();
            } 
            else if ($data['type'] === 'sell') {
                $totalBought = Trade::where('user_id', $user->id)
                                    ->where('stock_id', $stock->id)
                                    ->where('type', 'buy')
                                    ->sum('quantity');

                $totalSold = Trade::where('user_id', $user->id)
                                  ->where('stock_id', $stock->id)
                                  ->where('type', 'sell')
                                  ->sum('quantity');

                $ownedQuantity = $totalBought - $totalSold;

                if ($ownedQuantity < $data['quantity']) {
                    throw new \Exception("Você não possui ações suficientes para vender {$data['quantity']} de {$stock->symbol}.");
                }

                $user->balance += $totalPrice;
                $user->save();
            }

            return Trade::create([
                'user_id'   => $user->id,
                'stock_id'  => $stock->id,
                'type'      => $data['type'],
                'quantity'  => $data['quantity'],
                'price'     => $stock->price,
            ]);
        });
    }
}
