<?php

namespace App\DAO;

use App\Models\Transaction;

class TransactionDAO
{
    public function createTransaction(array $data)
    {
        return Transaction::create($data);
    }

    public function getTransactionsByUserId(int $userId)
    {
        return Transaction::where('user_id', $userId)->get();
    }
}
