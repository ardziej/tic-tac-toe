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
    private ?string $victory = '';

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

        if ($this->isGameCompleted()) {
            $this->victory = $this->getWinner();
        }

        $ticTacToeDTO = $this->ticTacToeDTO;
        $ticTacToeDTO->init($this->grid, $this->score, $this->nextPlayer, $this->victory);

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

    public function destroyGame(): void
    {
        $this->clearState('score');
        $this->clearState('grid');
    }

    public function getCurrentTurn(): string
    {
        return $this->nextPlayer;
    }

    public function restartGame(): void
    {
        $this->clearState('grid');
    }

    public function piece(string $player, int $x, int $y): int
    {
        if ( ! empty($this->grid[$x][$y])) {
            return 409;
        }

        if ($player !== $this->nextPlayer) {
            return 406;
        }

        $this->grid[$x][$y] = $this->nextPlayer;
        $this->setNextPlayer();
        if ($this->isGameCompleted()) {
            $this->victory = $this->getWinner();
            $this->updateScore($this->victory);
        }

        $this->saveState('score', $this->score);
        $this->saveState('nextPlayer', $this->nextPlayer);
        $this->saveState('grid', $this->grid);
        $this->saveState('victory', $this->victory);

        return 200;
    }

    private function setNextPlayer(): void
    {
        $this->nextPlayer = $this->nextPlayer === 'x' ? 'o' : 'x';
        $this->saveState('nextPlayer', $this->nextPlayer);
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
            'o' => 0,
        ];
    }

    private function updateScore(string $key): array
    {
        $this->score[$key] = ++$this->score[$key];

        return $this->score;
    }

    public function isGameCompleted(): bool
    {
        $winner = $this->getWinner();

        if ($winner) {
            return true;
        }

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->grid[$i][$j] === '') {
                    return false;
                }
            }
        }

        return true;
    }

    private function getWinner(): ?string
    {
        if ($winner = $this->checkHorizontal()) {
            return $winner;
        }

        if ($winner = $this->checkVertical()) {
            return $winner;
        }

        if ($winner = $this->checkDiagonal()) {
            return $winner;
        }

        return null;
    }

    private function checkHorizontal(): ?string
    {
        for ($i = 0; $i < 3; $i++) {
            $winner = $this->grid[$i][0];

            for ($j = 0; $j < 3; $j++) {
                if ($this->grid[$i][$j] !== $winner) {
                    $winner = null;
                    break;
                }
            }

            if ($winner !== null) {
                break;
            }
        }

        return $winner;
    }

    private function checkVertical(): ?string
    {
        for ($i = 0; $i < 3; $i++) {
            $winner = $this->grid[0][$i];

            for ($j = 0; $j < 3; $j++) {
                if ($this->grid[$j][$i] !== $winner) {
                    $winner = null;
                    break;
                }
            }

            if ($winner !== null) {
                break;
            }
        }

        return $winner;
    }

    private function checkDiagonal(): ?string
    {
        $winner = $this->grid[0][0];
        for ($i = 0; $i < 3; $i++) {
            if ($this->grid[$i][$i] !== $winner) {
                $winner = null;
                break;
            }
        }

        if ($winner === null) {
            $winner = $this->grid[0][2];
            for ($i = 0; $i < 3; $i++) {
                if ($this->grid[$i][2 - $i] !== $winner) {
                    $winner = null;
                    break;
                }
            }
        }

        return $winner;
    }

    private function getState(string $key): string|array|null
    {
        return Cache::get($key);
    }

    private function saveState(string $key, string|array $value): void
    {
        Cache::forever($key, $value);
    }

    private function clearState(string $key): void
    {
        Cache::forget($key);
    }
}
