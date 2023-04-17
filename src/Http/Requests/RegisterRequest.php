<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\Users\UserRequestDto;
use App\Http\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'required' => [
                'firstName', 'lastName', 'email', 'password'
            ],
        ];
    }

    public function dto(): UserRequestDto
    {
        $attributes = $this->all();

        return new UserRequestDto(
            $attributes['firstName'],
            $attributes['lastName'],
            $attributes['email'],
            $attributes['password'],
        );
    }
}