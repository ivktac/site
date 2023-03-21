<?php

class UserResponse
{
    public int $id;
    public string $login;
    public string $email;
    public bool $is_admin;

    public function __construct(int $id, string $login, string $email, bool $is_admin)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->is_admin = $is_admin;
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }
    
    public static function fromUser(array $user): UserResponse
    {
        return new UserResponse(
            $user['id'],
            $user['login'],
            $user['email'],
            $user['admin']
        );
    }
}