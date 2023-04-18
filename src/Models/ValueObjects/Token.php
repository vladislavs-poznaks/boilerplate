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

    private CarbonInterface $issuedAt;
    private CarbonInterface $expiresAt;

    public function __construct(
        private string $token
    )
    {
        $key = new Key(self::getKey(), self::ALG);

        try {
            $payload = JWT::decode($token, $key);
        } catch (Exception $exception) {
            throw new TokenException($exception->getMessage());
        }

        $this->issuedAt = Carbon::parse($payload->iss);
        $this->expiresAt = Carbon::parse($payload->exp);
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

    public static function make(string $token): self
    {
        return new self($token);
    }

    public static function issue(User $user): self
    {
        $token = JWT::encode(self::getPayload($user), self::getKey(), self::ALG);

        return new self($token);
    }

    private static function getPayload(User $user): array
    {
        $tokenIssuedAt = Carbon::now();
        $tokenExpiresAt = $tokenIssuedAt->clone()->addHour();

        return [
            'email' => $user->getEmail(),
            'iss' => $tokenIssuedAt->unix(),
            'exp' => $tokenExpiresAt->unix(),
        ];
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
