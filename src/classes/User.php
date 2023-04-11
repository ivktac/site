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
            (int)$data->id,
            $data->login,
            $data->email,
            (bool)$data->admin,
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
        global $conn;

        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "i", $id);

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die(mysqli_error($conn));
        }

        $result = mysqli_stmt_get_result($stmt);

        $user = mysqli_fetch_object($result);

        if (!$user) {
            return null;
        }

        return self::fromStdClass($user);
    }

    public function update(): void
    {
        global $conn;

        $query = "UPDATE users SET first_name = ?, last_name = ?, birthdate = ?, password = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssi",
            $this->first_name,
            $this->last_name,
            $this->birthdate,
            $this->password,
            $this->id
        );

        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            die(mysqli_error($conn));
        }

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
