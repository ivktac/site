<?php

function checkAllowedRights()
{
    if (isset($_SESSION["user"])) {
        $user = unserialize($_SESSION["user"]);
        if (!$user->is_admin) {
            header("Location: index.php");
        }
    }
}

function isValidLogin(string $login): bool
{
    return preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $login);
}

function isValidPassword(string $password): bool
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{7,}$/', $password);
}

function isValidEmail(string $email): bool
{
    return preg_match('/^[a-zA-Z0-9._-]+@[a-zA-z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
}

function registerUser(mysqli $conn, RegistrationData $data): UserResponse
{
    $stmt = mysqli_prepare($conn, "INSERT INTO users (login, password, email) VALUES (?, ?, ?)");

    $secret = password_hash($data->password, PASSWORD_BCRYPT);
    mysqli_stmt_execute($stmt, [$data->login, $secret, $data->email]);

    $res = mysqli_query($conn, "SELECT * FROM users WHERE login = '{$data->login}'");

    $user = mysqli_fetch_assoc($res);

    return UserResponse::fromDb($user);
}

function signInUser(mysqli $conn, LoginData $data): UserResponse | null
{
    $result = mysqli_query($conn, "SELECT * FROM users WHERE login = '{$data->login}'");

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        return UserResponse::fromDb($user);
    }

    return null;
}
