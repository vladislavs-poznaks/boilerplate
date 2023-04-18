<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\Http\UnauthenticatedException;
use App\Exceptions\ValueObjects\TokenException;
use App\Http\Request;
use App\Models\ValueObjects\Token;

abstract class AbstractAuthenticatedController
{
    public function __construct(Request $request)
    {
        try {
            Token::make($request->getBearerToken());
        } catch (TokenException $exception) {
            throw new UnauthenticatedException($exception->getMessage());
        }
    }
}
