<?php

declare(strict_types=1);

namespace App\DTO;

class TicTacToeDTO
{
    public array $board;
    public array $score;
    public string $currentTurn;
    public string $victory;

    public function init(
        array $board,
        array $score,
        string $currentTurn,
        string $victory,
    ) {
        $this->victory     = $victory;
        $this->currentTurn = $currentTurn;
        $this->score       = $score;
        $this->board       = $board;
    }

    public function toArray(): array
    {
        return [
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
        ];
    }
}
