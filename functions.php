<?php

function executeSqlQuery(string $query, string $types, array $params = null): mysqli_stmt
{
    global $conn;

    $statement = mysqli_prepare($conn, $query);

    if ($params) {
        mysqli_stmt_bind_param($statement, $types, ...$params);
    }

    mysqli_stmt_execute($statement);

    if (mysqli_errno($conn) != 0) {
        die(mysqli_error($conn));
    }

    return $statement;
}

function isUserExists(string $login, string $email): bool
{
    $query = "SELECT * FROM users WHERE login = ? OR email = ?";

    $statement = executeSqlQuery($query, "ss", [$login, $email]);

    return mysqli_stmt_num_rows($statement) > 0;
}

function validateRegistrationData(RegistrationData $data): array
{
    global $conn;

    $errors = [];

    if (!preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $data->login)) {
        $errors[] = "Login is required";
    }

    if (!preg_match('/^[a-zA-Zа-яА-Я0-9_-]{4,}$/u', $data->password)) {
        $errors[] = "Password is required";
    }

    if ($data->password !== $data->repeatedPassword) {
        $errors[] = "Password not match";
    }

    if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-z0-9.-]+\.[a-zA-Z]{2,}$/', $data->email)) {
        $errors[] = "Invalid email";
    }

    global $builder;

    if (!$builder->compare($data->captcha, $_SESSION["captcha"])) {
        $errors[] = "Invalid captcha";
    }

    // if (isUserExists($data->login, $data->email)) {
    //     $errors[] = "Login or email already exists";
    // }

    return $errors;
}

function registerUser(RegistrationData $data): void
{
    global $conn;

    $query = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";

    executeSqlQuery($query, ["sss", $data->login, password_hash($data->password, PASSWORD_BCRYPT), $data->email]);

    header("Location: index.php?action=registration_successful");
}

function signIn(LoginData $data): void
{
    global $conn, $errors;

    $query = "SELECT * FROM users WHERE login = ?";

    $statement = executeSqlQuery($query, "s", [$data->login]);

    $result = mysqli_stmt_get_result($statement);

    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($data->password, $user["password"])) {
        $_SESSION["user"] = $data->login;

        header("Location: index.php");
    
        return;
    }

    $errors[] = "Invalid login or password";
}