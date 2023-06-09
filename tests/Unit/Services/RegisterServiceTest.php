<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Dto\Auth\RegisterRequestDto;
use App\Exceptions\Services\LoginServiceException;
use App\Exceptions\Services\RegisterServiceException;
use App\Models\User;
use App\Models\ValueObjects\Password;
use App\Models\ValueObjects\Token;
use App\Repositories\Users\UserRepository;
use App\Services\RegisterService;
use Mockery;
use PHPUnit\Framework\TestCase;

class RegisterServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_an_exception_if_user_is_not_persisted()
    {
        $this->expectException(RegisterServiceException::class);

        $userRepositoryMock = Mockery::mock(UserRepository::class)->makePartial();

        $dto = new RegisterRequestDto(
            'test',
            'test',
            'test@test.com',
            'secret'
        );

        $userRepositoryMock
            ->shouldReceive('persistAndSync')
            ->withAnyArgs()
            ->once()
            ->andReturnFalse();

        $service = new RegisterService($userRepositoryMock);

        $service->process($dto);
    }

    /**
     * @test
     */
    public function it_persists_a_user_and_issues_a_token()
    {
        $userRepositoryMock = Mockery::mock(UserRepository::class)->makePartial();

        $dto = new RegisterRequestDto(
            'test',
            'test',
            'test@test.com',
            'secret'
        );

        $user = User::make(
            'test',
            'test',
            'test@test.com',
            Password::fromPlainPassword('secret')
        );

        $userRepositoryMock
            ->shouldReceive('persistAndSync')
            ->withAnyArgs()
            ->once()
            ->andReturnUsing(function (User $user) {
                $this->assertEquals('test@test.com', $user->getEmail());
                $this->assertTrue($user->getPassword()->isCorrect('secret'));

                return true;
            });

        $service = new RegisterService($userRepositoryMock);

        $token = $service->process($dto);

        $this->assertSame(Token::issue($user)->getToken(), $token->getToken());
    }
}