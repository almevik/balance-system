<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/user', fn() => Auth::user());
    Route::get('/balance-and-transactions', [TransactionController::class, 'getBalanceAndTransactions']);
    Route::get('/transactions', [TransactionController::class, 'getTransactions']);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('app');
});
