<?php

namespace UserLoginService\Application;

use Exception;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

class UserLoginService
{
    private FacebookSessionManager $facebookSessionManager;
    private array $loggedUsers = [];

    public function __construct(FacebookSessionManager $facebookSessionManager)
    {
        $this->facebookSessionManager = $facebookSessionManager;
    }

    /**
     * @throws Exception
     */
    public function manualLogin(User $user): void
    {
        if (in_array($user->getUsername(), $this->loggedUsers)) {
            throw new Exception('User already logged in');
        }

        $this->loggedUsers[] = $user->getUsername();
    }

    public function getUsersLogged(): array
    {
        return $this->loggedUsers;
    }

    public function getExternalSessions(): int
    {
        return $this->facebookSessionManager->getSessions();
    }

    public function logout(User $user): string
    {
        if (!in_array($user->getUsername(), $this->loggedUsers)) {
            return 'User not found';
        }
        return $this->facebookSessionManager->logout($user->getUsername());
    }
}
