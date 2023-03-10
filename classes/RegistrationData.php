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

    public static function hasValidLogin(string $login): bool
    {
        return preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $login);
    }

    public static function hasValidPassword(string $password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/', $password);
    }

    public static function hasValidEmail(string $email): bool
    {
        return preg_match('/^[a-zA-Z0-9._-]+@[a-zA-z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
    }

    public static function comparePasswords(string $password, string $repeatedPassword): bool
    {
        return $password == $repeatedPassword;
    }

    public static function testCaptcha(string $captcha): bool
    {
        global $builder;

        return $builder->compare($captcha, $_SESSION["captcha"]);
    }


    public function toUserRequest(): UserRequest
    {
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        return new UserRequest($this->login, $password, $this->email);
    }

    public function validate(): array
    {
        $errors = [];

        if (!$this::hasValidLogin($this->login)) {
            $errors[] = "Login should has at least 4 symbols and only letters, numbers, underscore or dash";
        }

        if (!$this::hasValidPassword($this->password)) {
            $errors[] = "Password should has at least 7 symbols, at least one uppercase letter, one lowercase letter and one number";
        }

        if (!$this::comparePasswords($this->password, $this->repeatedPassword)) {
            $errors[] = "Passwords do not match";
        }

        if (!$this::hasValidEmail($this->email)) {
            $errors[] = "Invalid email";
        }

        if (!$this::testCaptcha($this->captcha)) {
            $errors[] = "Invalid captcha";
        }

        return $errors;
    }
}