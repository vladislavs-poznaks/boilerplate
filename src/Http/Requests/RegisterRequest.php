<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\Users\UserDto;
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

    public function dto(): UserDto
    {
        $attributes = $this->all();

        return new UserDto(
            $attributes['firstName'],
            $attributes['lastName'],
            $attributes['email'],
            $attributes['password'],
        );
    }
}