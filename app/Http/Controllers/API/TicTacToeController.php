<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;

class TicTacToeController extends BaseAPIController
{
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'board'       => [
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                ],
                'score'       => [
                    'x' => 1,
                    '0' => 1,
                ],
                'currentTurn' => 'o',
                'victory'     => 'x',
            ]
        );
    }

    public function store(): JsonResponse
    {
        return response()->json(
            [
                'board'       => [
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                ],
                'score'       => [
                    'x' => 1,
                    '0' => 1,
                ],
                'currentTurn' => 'o',
                'victory'     => 'x',
            ]
        );
    }

    public function update(): JsonResponse
    {
        return response()->json(
            [
                'board'       => [
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                    [
                        "",
                        "",
                        "",
                    ],
                ],
                'score'       => [
                    'x' => 1,
                    '0' => 1,
                ],
                'currentTurn' => 'o',
                'victory'     => 'x',
            ]
        );
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
