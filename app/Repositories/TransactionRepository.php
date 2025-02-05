<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function createTransaction(int $userId, float $amount, string $description): Transaction
    {
        /** @var Transaction $transaction */
        $transaction = Transaction::query()->create([
            'user_id' => $userId,
            'amount' => $amount,
            'description' => $description,
        ]);

        return $transaction;
    }
}
