<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Auth\RegisterRequestDto;
use App\Exceptions\Services\RegisterServiceException;
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

        $persisted = $this->repository->persistAndSync($user);

        if (!$persisted) {
            throw new RegisterServiceException('Failed to persist user');
        }

        return Token::issue($user);
    }
}
