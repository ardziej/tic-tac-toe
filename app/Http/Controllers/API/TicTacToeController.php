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
        $ticTacToeService = $this->ticTacToeService;
        $ticTacToeService->getOrCreateGame();
        $ticTacToePieceResponseCode = $ticTacToeService->piece(
            $request->input('piece'),
            (int)$request->input('x'),
            (int)$request->input('y')
        );

        return match ($ticTacToePieceResponseCode) {
            409 => response()->json(['message' => 'Piece is being placed where a piece already is.'], 409),
            406 => response()->json(['message' => 'Piece is being placed out of turn.'], 406),
            default => response()->json($ticTacToeService->getOrCreateGame()->toArray()),
        };
    }

    public function update(): JsonResponse
    {
        $ticTacToeService = $this->ticTacToeService;
        $ticTacToeService->restartGame();
        $ticTacToeGameDTO = $ticTacToeService->getOrCreateGame();

        return response()->json($ticTacToeGameDTO->toArray());
    }

    public function destroy(): JsonResponse
    {
        $ticTacToeService = $this->ticTacToeService;
        $ticTacToeService->destroyGame();
        $ticTacToeCurrentTurn = $ticTacToeService->getCurrentTurn();

        return response()->json(
            [
                'currentTurn' => $ticTacToeCurrentTurn,
            ]
        );
    }
}
