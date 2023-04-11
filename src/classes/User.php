<?php

class User
{
    public int $id;
    public string $login;
    public string $email;
    public bool $admin;

    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $birthdate = null;
    public ?string $password = null;

    public function __construct(int $id, string $login, string $email, bool $admin,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $birthdate = null,
        ?string $password = null
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->admin = $admin;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birthdate = $birthdate;
        $this->password = $password;
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }
}
