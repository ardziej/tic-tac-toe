<?php

declare(strict_types=1);

namespace App\DTO;

class TicTacToeDTO
{
    public array $grid;
    public array $score;
    public string $currentTurn;
    public ?string $victory;

    public function init(
        array $grid,
        array $score,
        string $currentTurn,
        ?string $victory,
    ) {
        $this->victory     = $victory;
        $this->currentTurn = $currentTurn;
        $this->score       = $score;
        $this->grid        = $grid;
    }

    public function toArray(): array
    {
        return [
            'grid'        => $this->grid,
            'score'       => $this->score,
            'currentTurn' => $this->currentTurn,
            'victory'     => $this->victory,
        ];
    }
}
