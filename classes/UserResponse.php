<?php

class UserResponse
{
    public int $id;
    public string $login;
    public string $email;
    public bool $role;

    public function __construct(int $id, string $login, string $email, bool $role)
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->role = $role;
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