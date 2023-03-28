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

    public static function fromRequest(array $request): LoginData
    {
        return new LoginData($request["login"] ?? "", $request["password"] ?? "");
    }
}