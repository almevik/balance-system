<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Repositories\BalanceRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $userEmail,
        private float $amount,
        private ?string $description = null
    ) {
        $this->onQueue('transactions');
    }

    /**
     * @throws Exception
     */
    public function handle(
        UserRepository $userRepository,
        BalanceRepository $balanceRepository,
        TransactionRepository $transactionRepository
    ): void {
        $user = $userRepository->getUserByEmail($this->userEmail);
        $balance = $user->userBalance->balance;

        // Тут можно залогировать или что-то еще сделать с ошибкой, а не просто выплюнуть
        if ($this->amount < 0 && abs($this->amount) > $balance) {
            throw new Exception('Недостаточный баланс для операции');
        }

        $newBalance = $balance + $this->amount;

        DB::transaction(function () use ($user, $balanceRepository, $transactionRepository, $newBalance) {
            if (!$balanceRepository->updateBalance($user->id, $newBalance)) {
                throw new Exception("Ошибка обновления баланса");
            }

            $transactionRepository->createTransaction($user->id, $newBalance, $this->description);
        });
    }
}
