<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\DTO\TicTacToeDTO;
use App\Http\Requests\API\TicTacToeStoreRequest;
use App\Services\TicTacToe\TicTacToeService;
use Illuminate\Http\JsonResponse;

class TicTacToeController extends BaseAPIController
{
    public function __construct(
        public TicTacToeDTO $ticTacToeDTO,
        public TicTacToeService $ticTacToeService,
    ) {
    }

    public function index(): JsonResponse
    {
        $ticTacToeService = $this->ticTacToeService;
        $ticTacToeGame    = $ticTacToeService->getOrCreateGame();

        return response()->json($ticTacToeGame->toArray());
    }

    public function store(TicTacToeStoreRequest $request): JsonResponse
    {
        $ticTacToeDTO = $this->ticTacToeDTO;
        $ticTacToeDTO->init([], [], 'x', 'o');

        return response()->json($ticTacToeDTO->toArray());
    }

    public function update(): JsonResponse
    {
        $ticTacToeDTO = $this->ticTacToeDTO;
        $ticTacToeDTO->init([], [], 'x', 'o');

        return response()->json($ticTacToeDTO->toArray());
    }

    public function destroy(): JsonResponse
    {
        return response()->json(
            [
                'currentTurn' => 'x',
            ]
        );
    }
}
