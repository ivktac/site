<?php

class UserRequest
{
    public string $login;
    public string $password;
    public string $email;

    public function __construct(string $login, string $password, string $email)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }
}