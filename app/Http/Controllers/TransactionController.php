<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTransactionsRequest;
use App\Repositories\BalanceRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct(private TransactionRepository $transactionRepository) {}

    public function getBalanceAndTransactions(BalanceRepository $balanceRepository): JsonResponse
    {
        $user = Auth::user();
        $balance = $balanceRepository->getBalanceByUserId($user->id);
        $transactions = $this->transactionRepository->getByUserId($user->id);

        return response()->json([
            'user'         => $user,
            'balance'      => $balance,
            'transactions' => $transactions,
        ]);
    }

    public function getTransactions(GetTransactionsRequest $request): LengthAwarePaginator
    {
        $filter = $request->getFilter();

        return $this->transactionRepository->all(
            $filter['user_id'],
            $filter['search'],
            $filter['sort'],
            $filter['order'],
        );
    }
}
