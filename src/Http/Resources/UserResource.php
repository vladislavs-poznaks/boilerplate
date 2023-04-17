<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\HttpCode;
use App\Http\Response;
use App\Models\User;

class UserResource extends Response
{
    public function __construct(private User $user)
    {
    }

    public static function make(User $user, HttpCode $httpCode = HttpCode::OK): string
    {
        $resource = new self($user);

        return self::json([
            'firstname' => $resource->user->getFirstname(),
            'lastname' => $resource->user->getLastname(),
            'email' => $resource->user->getEmail(),
        ], $httpCode);
    }
}