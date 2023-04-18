<?php

declare(strict_types=1);

namespace App\Types;

use App\Models\ValueObjects\Password;
use Carbon\Carbon;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PasswordType extends Type
{
    public const NAME = 'password';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        // TODO: Implement getSQLDeclaration() method.
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return Password::make($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getHashedPassword();
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
