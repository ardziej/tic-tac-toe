<?php

declare(strict_types=1);

namespace App\Services\TicTacToe;

use App\DTO\TicTacToeDTO;
use Illuminate\Support\Facades\Cache;

class TicTacToeService
{
    private ?array $grid = [];
    private ?array $score = [];
    private ?string $nextPlayer = 'x';

    public function __construct(
        public TicTacToeDTO $ticTacToeDTO
    ) {
    }

    public function getOrCreateGame(): ?TicTacToeDTO
    {
        $currentGame = $this->getState('grid');

        if ( ! $currentGame) {
            $this->startGame();
            $this->saveGame();
        } else {
            $this->loadGame();
        }

        $ticTacToeDTO = $this->ticTacToeDTO;
        $ticTacToeDTO->init($this->grid, $this->score, $this->nextPlayer, '');

        return $ticTacToeDTO;
    }

    public function getGrid(): array
    {
        if (empty($this->grid)) {
            $this->grid = $this->initGrid();
        }

        return $this->grid;
    }

    public function startGame(): void
    {
        $this->grid  = $this->initGrid();
        $this->score = $this->initScore();
    }

    public function piece(int $x, int $y): bool
    {
        if (isset($this->grid[$x][$y])) {
            return false;
        }
        $this->grid[$x][$y] = $this->nextPlayer;

        $this->saveState('score', $this->score);
        $this->saveState('nextPlayer', $this->nextPlayer);
        $this->saveState('grid', $this->grid);

        return true;
    }

    private function saveGame(): void
    {
        $this->saveState('score', $this->score);
        $this->saveState('nextPlayer', $this->nextPlayer);
        $this->saveState('grid', $this->grid);
    }

    private function loadGame(): void
    {
        $this->grid       = $this->getState('grid');
        $this->score      = $this->getState('score');
        $this->nextPlayer = $this->getState('nextPlayer');
    }

    private function initGrid(): array
    {
        $grid = [];
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $grid[$i][$j] = '';
            }
        }

        return $grid;
    }

    private function initScore(): array
    {
        return [
            'x' => 0,
            'y' => 0,
        ];
    }

    private function getState(string $key): string|array|null
    {
        return Cache::get($key);
    }

    private function saveState(string $key, string|array $value): void
    {
        Cache::forever($key, $value);
    }
}
