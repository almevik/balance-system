<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function create(array $data): ?User
    {
        return DB::transaction(function () use ($data) {
            $user = User::query()->create($data);

            if (!$user) {
                return null;
            }

            UserBalance::query()->create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);

            return $user;
        });
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
