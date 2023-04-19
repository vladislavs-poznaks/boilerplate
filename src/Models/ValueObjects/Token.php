<?php

declare(strict_types=1);

namespace App\Models\ValueObjects;

use App\Exceptions\ValueObjects\TokenException;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{
    private const ALG = 'HS256';

    public function __construct(
        private string $token,
        private CarbonInterface $issuedAt,
        private CarbonInterface $expiresAt,
    )
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getIssuedAt(): CarbonInterface
    {
        return $this->issuedAt;
    }

    public function getExpiresAt(): CarbonInterface
    {
        return $this->expiresAt;
    }

    public static function issue(User $user): self
    {
        $tokenIssuedAt = Carbon::now();
        $tokenExpiresAt = $tokenIssuedAt->clone()->addHour();

        $payload = [
            'email' => $user->getEmail(),
            'iss' => $tokenIssuedAt->unix(),
            'exp' => $tokenExpiresAt->unix(),
        ];

        $token = JWT::encode($payload, self::getKey(), self::ALG);

        return new self($token, $tokenIssuedAt, $tokenExpiresAt);
    }

    public static function validate(?string $token)
    {
        if (!$token) {
            throw new TokenException('Missing token');
        }

        $key = new Key(self::getKey(), self::ALG);

        try {
            JWT::decode($token, $key);
        } catch (Exception $exception) {
            throw new TokenException($exception->getMessage());
        }
    }

    private static function getKey(): string
    {
        $key = $_ENV['JWT_SECRET_KEY'];

        if (is_null($key)) {
            throw new TokenException('JWT secret key is not set');
        }

        return $key;
    }
}
