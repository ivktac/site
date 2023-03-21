<?php

class RegistrationData
{
    public string $login;
    public string $password;
    public string $repeatedPassword;
    public string $email;
    public string $captcha;

    public function __construct(string $login, string $password, string $repeatPassword, string $email, string $captcha)
    {
        $this->login = $login;
        $this->repeatedPassword = $repeatPassword;
        $this->password = $password;
        $this->email = $email;
        $this->captcha = $captcha;
    }

    public static function fromRequest(array $request): RegistrationData
    {
        return new RegistrationData(
            $request['login'] ?? '',
            $request['password'] ?? '',
            $request['password-repeat'] ?? '',
            $request['email'] ?? '',
            $request['captcha'] ?? ''
        );
    }
}
