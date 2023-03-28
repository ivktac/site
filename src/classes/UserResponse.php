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
    
    public static function fromDb(array $data): UserResponse
    {
        return new UserResponse(
            $data['id'],
            $data['login'],
            $data['email'],
            $data['admin']
        );
    }
}