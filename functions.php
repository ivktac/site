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
    // global $conn;

    $errors = [];

    if (!$data::hasValidLogin($data->login)) {
        $errors[] = "Login should has at least 4 symbols and only letters, numbers, underscore or dash";
    }

    if (!$data::hasValidPassword($data->password)) {
        $errors[] = "Password should has at least 7 symbols, at least one uppercase letter, one lowercase letter and one number";
    }

    if ($data::comparePasswords($data->password, $data->repeatedPassword)) {
        $errors[] = "Passwords do not match";
    }

    if (!$data::hasValidEmail($data->email)) {
        $errors[] = "Invalid email";
    }

    if (!$data::testCaptcha($data->captcha)) {
        $errors[] = "Invalid captcha";
    }

    // if (isUserExists($data->login, $data->email)) {
    //     $errors[] = "Login or email already exists";
    // }

    return $errors;
}

function registerUser(RegistrationData $data): void
{
    $query = "INSERT INTO users (login, password, email) VALUES (?, ?, ?)";

    executeSqlQuery($query, "sss", [$data->login, password_hash($data->password, PASSWORD_BCRYPT), $data->email]);

    header("Location: index.php?action=registration_successful");
}

function signIn(LoginData $data): void
{
    global $errors;

    $query = "SELECT * FROM users WHERE login = ?";

    $statement = executeSqlQuery($query, "s", [$data->login]);

    $result = mysqli_stmt_get_result($statement);

    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($data->password, $user["password"])) {
        $_SESSION["user"] = UserResponse::fromUser($user);

        header("Location: index.php");

        return;
    }

    $errors[] = "Invalid login or password";
}