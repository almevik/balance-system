<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class AddUserCommand extends Command
{
    protected $signature = 'user:add {name} {email} {password}';
    protected $description = 'Добавляет пользователя';

    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $email = $this->argument('email');

        if ($this->userRepository->getUserByEmail($email)) {
            $this->error("Пользователь с email $email уже существует");

            return;
        }

        $name = $this->argument('name');
        $password = bcrypt($this->argument('password'));

        $user = $this->userRepository->create([
            'name'     => $name,
            'email'    => $email,
            'password' => $password,
        ]);

        if (!$user) {
            $this->error('Не удалось создать пользователя');

            return;
        }

        $this->info('User created successfully.');
    }
}
