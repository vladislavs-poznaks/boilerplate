<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Dto\Auth\RegisterRequestDto;
use App\Http\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        // TODO : Improve validation
        return [
            'required' => [
                'firstName', 'lastName', 'email', 'password'
            ],
        ];
    }

    public function dto(): RegisterRequestDto
    {
        $attributes = $this->all();

        return new RegisterRequestDto(
            $attributes['firstName'],
            $attributes['lastName'],
            $attributes['email'],
            $attributes['password'],
        );
    }
}