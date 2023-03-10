<?php

class LoginData
{
    public string $login;
    public string $password;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    public function signIn(mysqli $conn): UserResponse
    {
        $user = $conn->query("SELECT * FROM users WHERE login = '{$this->login}'")
            ->fetch_assoc();

        if (!$user && !password_verify($this->password, $user['password'])) {
            throw new Exception("Invalid login or password");
        }

        return UserResponse::fromUser($user);
    }
}