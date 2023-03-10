<?php

function registerUser(mysqli $conn, RegistrationData $data): UserResponse
{
    $statement = $conn->prepare("INSERT INTO users (login, password, email) VALUES (?, ?, ?)");
    $statement->execute([$data->login, password_hash($data->password, PASSWORD_BCRYPT), $data->email]);

    $user = $conn->query("SELECT * FROM users WHERE login = '{$data->login}'")->fetch_assoc();

    return UserResponse::fromUser($user);
}

function signIn(mysqli $conn, LoginData $data): UserResponse
{
    $user = $conn->query("SELECT * FROM users WHERE login = '{$data->login}'")->fetch_assoc();

    if (!$user && !password_verify($data->password, $user['password'])) {
        throw new Exception("Invalid login or password");
    }

    return UserResponse::fromUser($user);
}