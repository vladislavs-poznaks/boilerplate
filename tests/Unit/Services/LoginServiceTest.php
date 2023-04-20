<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Dto\Auth\LoginRequestDto;
use App\Exceptions\Services\LoginServiceException;
use App\Models\User;
use App\Models\ValueObjects\Password;
use App\Models\ValueObjects\Token;
use App\Repositories\Users\UserRepository;
use App\Services\LoginService;
use Mockery;
use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_an_exception_if_user_is_not_found()
    {
        $this->expectException(LoginServiceException::class);

        $userRepositoryMock = Mockery::mock(UserRepository::class)->makePartial();

        $dto = new LoginRequestDto(
            'test@test.com',
            'secret'
        );

        $userRepositoryMock
            ->shouldReceive('getByEmail')
            ->with('test@test.com')
            ->andReturnNull();

        $service = new LoginService($userRepositoryMock);

        $service->process($dto);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_user_is_found_but_password_do_not_match()
    {
        $this->expectException(LoginServiceException::class);

        $password = Password::fromPlainPassword('not_secret');

        $user = User::make(
            'test',
            'test',
            'test@test.com',
            $password
        );

        $userRepositoryMock = Mockery::mock(UserRepository::class)->makePartial();

        $dto = new LoginRequestDto(
            'test@test.com',
            'secret'
        );

        $userRepositoryMock
            ->shouldReceive('getByEmail')
            ->with('test@test.com')
            ->andReturn($user);

        $service = new LoginService($userRepositoryMock);

        $service->process($dto);
    }

    /**
     * @test
     */
    public function it_issues_a_token_if_credentials_are_correct()
    {
        $password = Password::fromPlainPassword('secret');

        $user = User::make(
            'test',
            'test',
            'test@test.com',
            $password
        );

        $userRepositoryMock = Mockery::mock(UserRepository::class)->makePartial();

        $dto = new LoginRequestDto(
            'test@test.com',
            'secret'
        );

        $userRepositoryMock
            ->shouldReceive('getByEmail')
            ->with('test@test.com')
            ->andReturn($user);

        $service = new LoginService($userRepositoryMock);

        $token = $service->process($dto);

        $this->assertSame(Token::issue($user)->getToken(), $token->getToken());
    }
}