<?php

namespace Tests\Feature;

use Tests\TestCase;

class TicTacToeTest extends TestCase
{
    public function test_tic_tac_toe_index_api_request(): void
    {
        $response = $this->getJson('/api/');

        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    'grid'        => [
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
                        'x' => 0,
                        'o' => 0,
                    ],
                    'currentTurn' => 'x',
                    'victory'     => '',
                ],
            );
    }

    public function test_tic_tac_toe_update_api_request(): void
    {
        $response = $this->postJson('/api/restart');

        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    'grid'        => [
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
                        'x' => 0,
                        'o' => 0,
                    ],
                    'currentTurn' => 'x',
                    'victory'     => '',
                ],
            );
    }

    public function test_tic_tac_toe_store_api_request(): void
    {
        $response = $this->postJson('/api/x', ['x' => 1, 'y' => 2]);

        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    'grid'        => [
                        [
                            "",
                            "",
                            "",
                        ],
                        [
                            "",
                            "",
                            "x",
                        ],
                        [
                            "",
                            "",
                            "",
                        ],
                    ],
                    'score'       => [
                        'x' => 0,
                        'o' => 0,
                    ],
                    'currentTurn' => 'o',
                    'victory'     => '',
                ],
            );
    }

    public function test_tic_tac_toe_store_api_406_request(): void
    {
        $response = $this->postJson('/api/o', ['x' => 1, 'y' => 2]);

        $response
            ->assertStatus(406)
            ->assertJson(
                [
                    'message' => 'Piece is being placed out of turn.',
                ],
            );
    }

    public function test_tic_tac_toe_store_api_409_request(): void
    {
        $response = $this->postJson('/api/x', ['x' => 1, 'y' => 2]);
        $response->assertStatus(200);

        $responseSecond = $this->postJson('/api/x', ['x' => 1, 'y' => 2]);
        $responseSecond->assertStatus(409)
                       ->assertJson(
                           [
                               'message' => 'Piece is being placed where a piece already is.',
                           ],
                       );
    }

    public function test_tic_tac_toe_destroy_api_request(): void
    {
        $response = $this->deleteJson('/api/');

        $response
            ->assertStatus(200)
            ->assertJson(
                [
                    'currentTurn' => 'x',
                ],
            );
    }
}
