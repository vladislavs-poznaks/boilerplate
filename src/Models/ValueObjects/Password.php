<?php

declare(strict_types=1);

namespace App\Models\ValueObjects;

class Password
{
    public function __construct(
        private string $hashedPassword
    )
    {
    }

    public function isCorrect(string $password): bool
    {
        return password_verify(self::salt($password), $this->hashedPassword);
    }

    public function isIncorrect(string $password): bool
    {
        return !$this->isCorrect($password);
    }

    public static function make(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public static function fromPlainPassword(string $password): self
    {
        // TODO : Consider some validation to restrict length as BCRYPT truncates max to 72 bytes

        $hashedPassword = password_hash(self::salt($password), PASSWORD_BCRYPT);

        return new self($hashedPassword);
    }

    private static function salt(string $password): string
    {
        $salt = $_ENV['PASSWORD_SALT'] ?? '';

        if (is_null($salt)) {
            return $password;
        }

        return $password . '_' . $salt;
    }
}
