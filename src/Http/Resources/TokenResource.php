<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Http\HttpCode;
use App\Http\Response;
use App\Models\ValueObjects\Token;

class TokenResource extends Response
{
    public static function make(Token $token, HttpCode $httpCode = HttpCode::OK): string
    {
        return self::json([
            'token' => $token->getToken(),
            'issued_at' => $token->getIssuedAt()->unix(),
            'expires_at' => $token->getExpiresAt()->unix(),
        ], $httpCode);
    }
}
