<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\Users\UserRequestDto;
use App\Models\User;
use App\Repositories\Users\UserRepository;

class UserRegistrationService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function process(UserRequestDto $dto): User
    {
        $user = User::make(
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $dto->getPassword(),
//            $this->getHashedPassword($dto->getPassword())
        );

        $this->repository->persistAndSync($user);

        return $user;
    }

    private function getHashedPassword(string $password): string
    {
        return md5($password);
    }
}
