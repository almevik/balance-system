<?php

namespace App\Http\Controllers;

use App\Repositories\BalanceRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function getTransactions(Request $request): LengthAwarePaginator
    {
        return $this->transactionRepository->all(
            auth()->id(),
            $request->input('search'),
            $request->input('sort', 'transaction_date'),
            $request->input('order', 'desc')
        );
    }
}
