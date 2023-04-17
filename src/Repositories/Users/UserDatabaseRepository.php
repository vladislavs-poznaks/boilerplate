<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\DatabaseRepository;
use Doctrine\ORM\Exception\ORMException;

class UserDatabaseRepository extends DatabaseRepository implements UserRepository
{
    public function persist(User $user): void
    {
        static::entityManager()->persist($user);
    }

    public function sync(User $user): bool
    {
        try {
            static::entityManager()->flush($user);

            return true;
        } catch (ORMException) {
            return false;
        }
    }

    public function persistAndSync(User $user): bool
    {
        $this->persist($user);

        return $this->sync($user);
    }
}
