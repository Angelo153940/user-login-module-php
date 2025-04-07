<?php

namespace UserLoginService\Domain;

class User
{
    private string $userName;

    public function __construct(string $userName)
    {
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }
}
