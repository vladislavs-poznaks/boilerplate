<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Auth\RegisterRequestDto;
use App\Models\User;
use App\Models\ValueObjects\Password;
use App\Models\ValueObjects\Token;
use App\Repositories\Users\UserRepository;

class RegisterService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function process(RegisterRequestDto $dto): Token
    {
        $password = Password::fromPlainPassword($dto->getPassword());

        $user = User::make(
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $password,
        );

        $this->repository->persistAndSync($user);

        return Token::issue($user);
    }
}
