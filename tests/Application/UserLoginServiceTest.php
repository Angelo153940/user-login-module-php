<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use Exception;
use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;
use Mockery;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     * @throws Exception
     */
    public function userIsLoggedIn(): void
    {
        $user = new User('Angelo');
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $userLoginService = new UserLoginService($facebookSessionManager);

        $userLoginService->manualLogin($user);

        $this->assertEquals(['Angelo'], $userLoginService->getUsersLogged());
    }

    /**
     * @test
     * @throws Exception
     */
    public function userAlreadyLoggedIn(): void
    {
        $user = new User('Angelo');
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $userLoginService = new UserLoginService($facebookSessionManager);

        $this->expectExceptionMessage('User already logged in');
        $userLoginService->manualLogin($user);
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     */
    public function getNumberOfActiveSessions(): void
    {
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $facebookSessionManager->shouldReceive('getSessions')->once()->andReturn(4);

        $userLoginService = new UserLoginService($facebookSessionManager);

        $this->assertEquals(4, $userLoginService->getExternalSessions());
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Para cerrar los mocks al terminar los tests
    }
}
