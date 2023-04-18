<?php

declare(strict_types=1);

namespace App\Dto\Auth;

use App\Dto\Dto;

class LoginRequestDto extends Dto
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
