<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Auth\LoginRequestDto;
use App\Exceptions\Services\LoginServiceException;
use App\Models\ValueObjects\Token;
use App\Repositories\Users\UserRepository;

class LoginService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function process(LoginRequestDto $dto): Token
    {
        $user = $this->repository->getByEmail($dto->getEmail());

        if (is_null($user)) {
            throw new LoginServiceException('Incorrect credentials');
        }

        if ($user->getPassword()->isIncorrect($dto->getPassword())) {
            throw new LoginServiceException('Incorrect credentials');
        }

        return Token::issue($user);
    }
}
