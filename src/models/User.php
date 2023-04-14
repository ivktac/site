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

    public function __construct(
        int $id,
        string $login,
        string $email,
        bool $admin,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $birthdate = null,
        ?string $password = null
    ) {
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->admin = $admin;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birthdate = $birthdate;
        $this->password = $password;
    }

    public static function fromStdClass(stdClass $data): User
    {
        return new self(
            (int) $data->id,
            $data->login,
            $data->email,
            (bool) $data->admin,
            $data->first_name ?? null,
            $data->last_name ?? null,
            $data->birthdate ?? null,
            $data->password ?? null
        );
    }

    public static function isAuth(): bool
    {
        return isset($_SESSION["user"]);
    }

    public static function getAuthUser(): ?User
    {
        if (isset($_SESSION["user"])) {
            return unserialize($_SESSION["user"]);
        }

        return null;
    }

    public static function getById(int $id): ?User
    {
        global $mysqli;

        $result = $mysqli->query("SELECT * FROM users WHERE id = $id");

        if (!$result) {
            die($mysqli->error);
            return null;
        }

        $data = $result->fetch_object();

        if (!$data) {
            return null;
        }

        return self::fromStdClass($data);
    }

    public static function validate(User $user): array
    {
        $errors = [];

        if (!preg_match("/^[a-zA-Z0-9]{3,}$/", $user->login)) {
            $errors["Login"] = "Login must contain only letters and numbers and be at least 3 characters long";
        }

        if (!preg_match("/^[a-zA-Z0-9]{3,}$/", $user->password)) {
            $errors["password"] = "Password must contain only letters and numbers and be at least 3 characters long";
        }

        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $user->email)) {
            $errors["email"] = "Invalid email";
        }

        return $errors;
    }

    public static function authenticate(array $data): void
    {
        $user = self::fromStdClass((object) $data);

        $_SESSION["user"] = serialize($user);
    }

    public function save(): void
    {
        global $mysqli;

        $mysqli->query("INSERT INTO users (login, email, password) 
            VALUES ('$this->login', '$this->email', '$this->password')");

        $this->id = $mysqli->insert_id;

        $_SESSION["user"] = serialize($this);
    }

    public function update(): void
    {
        global $mysqli;

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $mysqli->query("UPDATE users SET first_name = '$this->first_name', 
            last_name = '$this->last_name', birthdate = '$this->birthdate', 
            password = '$this->password' WHERE id = $this->id");

        $_SESSION["user"] = serialize($this);
    }

    public function getFullName(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }
}
