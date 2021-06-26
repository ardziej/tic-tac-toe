<?php

use App\Http\Controllers\API\TicTacToeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TicTacToeController::class, 'index']);
Route::post('/{piece}', [TicTacToeController::class, 'store']);
Route::post('/restart', [TicTacToeController::class, 'update']);
Route::delete('/', [TicTacToeController::class, 'destroy']);
