<?php

declare(strict_types=1);

namespace App\Models;

use App\Dto\Users\UserRequestDto;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('users')]
class User
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(name: 'created_at')]
    private CarbonInterface $createdAt;

    #[Column(name: 'updated_at')]
    private CarbonInterface $updatedAt;

    public function __construct(
        #[Column(name: 'first_name')]
        private string $firstName,
        #[Column(name: 'last_name')]
        private string $lastName,
        #[Column(name: 'email')]
        private string $email,
        #[Column(name: 'password')]
        private string $password,
        ?CarbonInterface $createdAt = null,
        ?CarbonInterface $updatedAt = null
    )
    {
        $this->createdAt = $createdAt ?? Carbon::now();
        $this->updatedAt = $updatedAt ?? Carbon::now();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public static function make(
        string $firstname,
        string $lastName,
        string $email,
        string $password
    ): self
    {
        return new self(
            $firstname,
            $lastName,
            $email,
            $password
        );
    }
}
