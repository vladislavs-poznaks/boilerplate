<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\User;

interface UserRepository
{
    public function persist(User $user): void;

    public function sync(User $user): bool;

    public function persistAndSync(User $user): bool;
}
