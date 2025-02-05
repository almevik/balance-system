<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserBalance;

class BalanceRepository
{
    public function getBalanceByUserId(int $userId): float
    {
        return UserBalance::query()->where('user_id', $userId)->value('balance') ?? 0;
    }

    public function updateBalance(int $userId, float $amount): bool
    {
        return UserBalance::query()->where('user_id', $userId)->update(['balance' => $amount]) > 0;
    }
}
