<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use Illuminate\Console\Command;
use App\Jobs\ProcessTransactionJob;

class PerformTransactionCommand extends Command
{
    protected $signature = 'transaction:perform {login} {amount} {description}';
    protected $description = 'Выполняет транзакцию для пользователя';

    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $login = $this->argument('login');
        $amount = (float) $this->argument('amount');
        $description = $this->argument('description');

        $user = $this->userRepository->getUserByEmail($login);

        if (!$user) {
            $this->error('Пользователь не найден');

            return;
        }

        dispatch(new ProcessTransactionJob($login, $amount, $description));

        $this->info('Транзакция запущена через очередь');
    }
}
