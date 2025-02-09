<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function getByUserId(int $userId, int $limit = 5): Collection
    {
        return Transaction::query()
            ->where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->limit($limit)
            ->get();
    }

    public function all(
        int $userId,
        ?string $search = null,
        ?string $sort = 'transaction_date',
        ?string $order = 'desc',
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = Transaction::query()
            ->where('user_id', $userId);

        if ($search) {
            $query->where('description', 'like', "%$search%");
        }

        $query->orderBy($sort, $order);

        return $query->paginate($perPage);
    }
}
