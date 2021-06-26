<?php

declare(strict_types=1);

namespace App\Http\Requests\API;

class TicTacToeStoreRequest extends BaseAPIRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['piece' => $this->route('piece')]);
    }

    public function rules(): array
    {
        return [
            'piece' => 'required|string|size:1|in:x,o',
            'x'     => 'required|integer|between:0,2',
            'y'     => 'required|integer|between:0,2',
        ];
    }
}
