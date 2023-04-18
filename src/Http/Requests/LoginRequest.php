<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\Auth\LoginRequestDto;
use App\Http\Request;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'required' => [
                'email', 'password'
            ],
        ];
    }

    public function dto(): LoginRequestDto
    {
        $attributes = $this->all();

        return new LoginRequestDto(
            $attributes['email'],
            $attributes['password'],
        );
    }
}
